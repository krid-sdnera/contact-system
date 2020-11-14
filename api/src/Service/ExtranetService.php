<?php

namespace App\Service;

use Exception;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

use League\Csv\Reader;

use Doctrine\ORM\EntityManagerInterface;
use DateTime;

use App\Entity\Member;
use App\Entity\Contact;
use App\Entity\MemberRole;
use App\Entity\Role;
use App\Entity\Section;
use App\Entity\ScoutGroup;
use App\Entity\ExtranetMember;
use App\Entity\ExtranetContact;

class ExtranetService
{
    private $_useCache = false;
    private $credentials = [
        'username' => '',
        'password' => ''
    ];
    private $cacheDirectory;
    /**
     * @var HttpClientInterface
     */
    private $client;

    private $extranetMembers = [];

    // I don't really want to assume but... VicScouts likes javascript ambiguities
    const MemberContactHeaders = ['Relationship', 'Title', 'Firstname', 'Surname', 'Preferedname', 'Occupation', 'Contact', 'Address', 'PrimaryContact'];

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function setCacheDirectory($cacheDirectory): self
    {
        $this->cacheDirectory = $cacheDirectory;
        return $this;
    }

    public function setCredentials($username, $password): self
    {
        $this->credentials = [
            'username' => $username,
            'password' => $password
        ];
        return $this;
    }

    public function useCache(bool $cache = false)
    {
        $this->_useCache = $cache;
        return $this;
    }

    public static function HttpClientFactory($cookie = ''): HttpClientInterface
    {
        return HttpClient::createForBaseUri('https://www.vicscouts.asn.au', [
            'headers' => [
                'Host' => 'www.vicscouts.asn.au',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Connection' => 'Keep-Alive',
                'Content-type' => 'application/x-www-form-urlencoded;charset=UTF-8',
                'Accept-Language' => 'en-US,en;q=0.5',
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:51.0) Gecko/20100101 Firefox/51.0',
                'Cookie' => $cookie
            ],
        ]);
    }

    public function setClient(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function doExtract()
    {
        $this->getExtranetData();

        Member::setEntityManager($this->em);
        Contact::setEntityManager($this->em);
        MemberRole::setEntityManager($this->em);
        Role::setEntityManager($this->em);
        Section::setEntityManager($this->em);
        ScoutGroup::setEntityManager($this->em);

        /** @var Member[] */
        $members = [];
        foreach ($this->extranetMembers as $i => $extranetMember) {
            echo "Processing Member {$extranetMember->getMembershipNumber()}" . PHP_EOL;
            /** @var Member */
            $member = Member::fromExtranetMember($extranetMember);
            $members[] = $member;
        }

        $membersToPersist =  $this->extranet_import($members);

        foreach ($membersToPersist as $i => $member) {
            $this->em->persist($member);
        }

        $this->em->flush();
    }

    private function getExtranetData()
    {
        if ($this->_useCache) {
            echo 'Using cache data' . PHP_EOL;

            $data = json_decode(file_get_contents($this->cacheDirectory . 'extranet-data.json'), true);

            $this->extranetMembers = array_map(
                function ($member) {
                    return ExtranetMember::fromArray($member);
                },
                $data
            );

            echo 'Cache data loaded successfully' . PHP_EOL;

            return;
        }

        $this->setClient(self::HttpClientFactory());

        $this->doExtranetLogin();

        $this->getExtranetReport('total_grand');
        $this->getExtranetReport('ob');

        // Update Cache
        file_put_contents(
            $this->cacheDirectory . 'extranet-data.json',
            json_encode(array_map(
                function ($member) {
                    return $member->toArray();
                },
                $this->extranetMembers
            ), JSON_PRETTY_PRINT)
        );
    }

    private function doExtranetLogin(): void
    {
        echo 'Doing login' . PHP_EOL;
        $loginResponse = $this->client->request('POST', '/portal/loginCheck.php?var=', [
            'body' => [
                'username' => $this->credentials['username'],
                'password' => $this->credentials['password'],
                'form_submission' => ''
            ]
        ]);

        // Get cookie and regenerate Http Client
        $cookie = $loginResponse->getHeaders()['set-cookie'][0];
        $this->setClient(self::HttpClientFactory($cookie));

        $_2fa_security_question = $this->client->request(
            'POST',
            '/portal/twoFactorAuth.php',
            [
                'body' => [
                    "username" => $this->credentials['username'],
                    "password" => $this->credentials['password'],
                    "authMethod" => "QUESTION",
                    "authFormAction" => "validate",
                    "questionID" => "3",
                    "answerInput" => "3040",
                    "btnSubmitQuestionAnswer" => "Submit"
                ]
            ]
        );

        $loginResponse = $this->client->request(
            'POST',
            '/portal/authNext.php',
            [
                'body' => [
                    "username" => $this->credentials['username'],
                    "authprocess" => "authNext"
                ]
            ]
        );

        $this->checkExtranetLoginCensus($loginResponse);
        $this->checkExtranetLoginInsurance($loginResponse);
        $this->checkExtranetLoginPasswordExpiry($loginResponse);
        $this->checkExtranetLoginSuccessfull($loginResponse);

        echo 'Logged in' . PHP_EOL;
    }

    private function checkExtranetLoginCensus(ResponseInterface $response): void
    {
        echo 'Checking login for census' . PHP_EOL;
        $content = $response->getContent();

        // Check for the existance of the census style redirect
        preg_match(
            '|<body onLoad="javascript:window.location.replace\(\'(/portal/Interface/MSUCensus/CensusCount/pfcConfirmReport.php)\'\)"></body>|',
            $content,
            $matches
        );

        if (count($matches) !== 2) {
            // Census not active
            return;
        }

        // Fetch Census Report page
        $censusResponse = $this->client->request('GET', '/portal/Interface/MSUCensus/CensusCount/pfcConfirmReport.php');

        // Check that there is a verify button
        preg_match(
            "|onclick=\"verify\(false,'(\d+)','(redirect)'\)\"|",
            $censusResponse,
            $matches
        );

        if (count($matches) !== 3) {
            // There was no verify button
            throw new Exception('Census active: verify button not found.');
        }

        // Fetch Census confirm page
        $censusConfirmResponse = $this->client->request('GET', '/portal/Interface/MSUCensus/CensusCount/pfcConfirmAction.php', [
            'query' => [
                'groupID' =>  $matches[1],
                'pTarget' => $matches[2],
                'bConfirm' => 'N',
            ]
        ]);

        // TODO do we need to check the thing here?
    }

    private function checkExtranetLoginInsurance(ResponseInterface $response): void
    {
        echo 'Checking login for insurance' . PHP_EOL;
        $content = $response->getContent();

        // Check for the existance of the insurance style redirect
        preg_match(
            '|<body onLoad="javascript:window.location.replace\(\'(/portal/Controllers/controller_extranet\.php\?request\=Insurance\.Questionnaire\.Open\&FromLogin\=yes)\'\)"></body>|',
            $content,
            $matches
        );

        if (count($matches) !== 2) {
            // Insurance not active
            return;
        }

        // Fetch Insurance Questionnaire page
        $insuranceResponse = $this->client->request('GET', '/portal/Controllers/controller_extranet.php', [
            'query' => [
                'request' => 'Insurance.Questionnaire.Open',
                'FromLogin' => 'yes'
            ]
        ]);

        // Check that there is a verify button
        preg_match(
            "|(Proceed to Extranet)|",
            $insuranceResponse,
            $matches
        );

        if (count($matches) !== 2) {
            // There was no verify button
            throw new Exception('Insurance active: verify button not found.');
        }
    }

    private function checkExtranetLoginPasswordExpiry(ResponseInterface $response): void
    {
        echo 'Checking login for password expiry' . PHP_EOL;
        $content = $response->getContent();

        // Check for the existance of the password expiry style redirect
        preg_match(
            '|<title> Password expire in \d+ days? <\/title>|',
            $content,
            $matches
        );

        if (count($matches) !== 2) {
            // Password has not expired
            return;
        }

        // Set active module to the change password interface
        $this->client->request('POST', '/portal/Interface/mainPage.php', [
            'body' => [
                'mainWindow' => '/Module1/memberModifyPasswordInterface.php'
            ]
        ]);

        // Change password to the existing password
        $passwordChangeResponse = $this->client->request('POST', '/portal/Interface/mainPage.php', [
            'body' => [
                'cPass' => $this->credentials['password'],
                'newPass1' => $this->credentials['password'],
                'newPass2' => $this->credentials['password'],
                'submitPass' => 'Save'
            ]
        ]);

        // Check that the password was updated
        preg_match(
            "|Change of password succesful. Your password will expire in (\d+) days.|",
            $passwordChangeResponse,
            $matches
        );

        if (count($matches) !== 2) {
            // Unable to update password
            throw new Exception('Password expiring: cannot update password');
        }

        echo 'Password updated successfully. Your password will expire in ' . $matches[1] . ' days.' . PHP_EOL;
    }

    private function checkExtranetLoginSuccessfull(ResponseInterface $response): void
    {
        echo 'Checking login for success' . PHP_EOL;
        $content = $response->getContent();

        // Check for the existance of the successful login style redirect
        preg_match(
            '|<body onLoad="javascript:window.location.replace\(\'/portal/Interface/mainPage.php\?var=(\d+)\'\)"></body>|',
            $content,
            $matches
        );

        if (count($matches) !== 2) {
            // Unable to login
            throw new Exception('Unable to Login! Check the credentials');
        }
    }

    public function getExtranetReport($reportName)
    {
        echo 'Begin report ' . $reportName . PHP_EOL;
        $response = $this->client->request('POST', '/portal/Interface/Report/XMLReport/Listing/listLevel.php', [
            'query' => [
                'setting' => 'activememberlisting',
                'reportFormat' => 'hierarchy',
                'category' => $reportName,
                'startDate' => '',
                'endDate' => ''
            ],
            'body' => [
                'group_hiddenIDList' => '3350505|',
                'district_hiddenIDList' => '',
                'extendStartDate' => '',
                'extendEndDate' => '',
                'reportType' => '',
                'extraOption1' => '',
                'levelType' => 'group',
                'strLevelIDList' => '*|'
            ]
        ]);

        $content = $response->getContent();

        // Extract report csv url
        preg_match(
            '|/portal/Interface/Include/getCSV2.php\?f=/data/apache/www.vicscouts.asn.au/root/portal/PDF/csv(\d+)\.csv|',
            $content,
            $matches
        );

        if (count($matches) !== 2) {
            throw new Exception('Cannot get csv link for ' . $reportName);
        }

        $response = $this->client->request('GET', '/portal/Interface/Include/getCSV2.php?f=/data/apache/www.vicscouts.asn.au/root/portal/PDF/csv' . $matches[1] . '.csv');
        $content = $response->getContent();

        // Update Cache
        file_put_contents(
            $this->cacheDirectory . $reportName . '.csv',
            $content
        );

        $csv = Reader::createFromString($content);
        $csv->setHeaderOffset(0);

        // $header = $csv->getHeader();
        $records = $csv->getRecords();

        foreach ($records as $i => $record) {
            $this->processReportRecord($record);
        }
    }

    private function processReportRecord($record)
    {
        echo 'Processing ' . $record['RegID'] . PHP_EOL;

        $extranetMember = ExtranetMember::fromExtranetCsv($record);

        $this->getMemberDetailPage($extranetMember);
        $this->getMemberUpdateLink($extranetMember);
        $this->getMemberContacts($extranetMember);

        // TODO: Roles and section
        // TODO: Map remaining csv keys

        $this->extranetMembers[] = $extranetMember;
    }

    private function getMemberDetailPage(ExtranetMember $extranetMember)
    {
        // Fetch additional data from member detail page
        $response = $this->client->request('GET', '/portal/Interface/Report/showMemDetail.php', [
            'query' => [
                'regg' => $extranetMember->getMembershipNumber()
            ]
        ]);

        $content = $response->getContent();

        // Extract the member's gender
        preg_match(
            '|>Gender:</td>\s*<td>\s*(.+?)\s*</td>|',
            $content,
            $matches
        );
        $gender = (count($matches) === 2) ? $matches[1] : null;
        $extranetMember->setGender($gender);

        // Extract the member's year level
        preg_match(
            '|>Year Level:</td>\s*<td>\s*(.+?)\s*</td>|',
            $content,
            $matches
        );
        $yearLevel = (count($matches) === 2) ? $matches[1] : null;
        $extranetMember->setSchoolYearLevel($yearLevel);

        // Extract the member's subsidiary sections
        preg_match(
            '|Current Subsidiary Section:</td><td><b>Start Date</b></td></tr>(.+?)</table>|',
            $content,
            $matches
        );

        if (count($matches) === 2) {
            // Extract each row
            preg_match_all(
                '|<td>(.+?) \((.+?)\).*?</td>|',
                $matches[1],
                $matchGroups,
                PREG_SET_ORDER
            );

            foreach ($matchGroups as $i => $group) {
                $extranetMember->addSubsidiarySection([
                    'SectionName' => $group[1],
                    'SectionID'   => $group[2]
                ]);
            }
        } // else don't mind

    }

    private function getMemberUpdateLink(ExtranetMember $extranetMember)
    {
        // Downloading: Member Update Link
        $response = $this->client->request('POST', '/portal/membership/get-member-key', [
            'query' => ['regid' => $extranetMember->getMembershipNumber()],
            'headers' => ['X-Requested-With: XMLHttpRequest']
        ]);
        $content = $response->getContent();

        $memberUpdateLink = (preg_match('|/memberportal/vic/|', $content)) ? $content : null;
        $extranetMember->setMemberUpdateLink($memberUpdateLink);
    }

    private function getMemberContacts(ExtranetMember $extranetMember)
    {

        // Downloading: Parent Data
        $response = $this->client->request('POST', '/portal/Interface/Leader/editParentalDetail_Controller.php', [
            'body' => [
                'page' => 1,
                'rp' => 10,
                'sortname' => 'parentFirstname',
                'sortorder' => 'asc',
                'query' => '',
                'qtype' => '',
                'action' => 'retrieve_parent_by_child',
                'regid' => $extranetMember->getMembershipNumber(),
            ],
            'headers' => ['X-Requested-With: XMLHttpRequest']
        ]);
        $content = $response->getContent();
        $parentData = json_decode($content, true);

        if (empty($parentData['rows'])) {
            return;
        }

        foreach ($parentData['rows'] as $i => $parentRow) {
            $parent = array_combine(self::MemberContactHeaders, $parentRow['cell']);
            $parent['ParentID'] = $parentRow['id'];

            // Handle Contact numbers
            $contact = explode('<br />', $parent['Contact']);
            foreach ($contact as $ii => $value) {
                $contacts = explode(': ', $value, 2);
                if (count($contacts) == 0) {
                    throw new Exception("Well damn");
                }
                if (empty($contacts[0])) {
                    continue;
                }
                if (count($contacts) == 1) {
                    $contacts[1] = "";
                }

                $parent[str_replace(' ', '', $contacts[0])] = $contacts[1];
            }

            // Handle Address
            $address = explode('<br />', $parent['Address'], 3);
            if (count($address) != 3) {
                throw new Exception("Well damn");
            }
            $parent['HomeAddress'] = $address[0];
            $parent['HomeSuburb'] = $address[1];
            $parts = explode(' ', $address[2], 2);
            if (count($parts) != 2) {
                throw new Exception("Well damn");
            }
            $parent['HomeState'] = $parts[0];
            $parent['HomePostcode'] = $parts[1];

            // Handle Primary contact
            $parent['PrimaryContact'] = substr($parent['PrimaryContact'], 0, 1);

            $extranetMember->addContact(ExtranetContact::fromExtranetCsv($parent));
        }
    }

    private function extranet_import(array $members)
    {

        /** @var MemberRepository */
        $memberRepo = $this->em->getRepository(Member::class);

        $managedMemberIds = $memberRepo->findIdsBy([
            'managementState' => Member::ManagementStateManaged
        ]);

        $extranetMembersConsidered = [];
        foreach ($members as $i => $member) {
            if ($this->em->contains($member)) {
                $extranetMembersConsidered[] = $member->getId();
            }
        }

        /** @var MemberRepository */
        $memberRepo = $this->em->getRepository(Member::class);

        $updatedMembers = [];
        foreach ($managedMemberIds as $i => $memberId) {
            // Is this member also in extranet?
            if (in_array($memberId, $extranetMembersConsidered)) {
                // Yes this member is in extranet
            } else {
                // No this contact is not in extranet
                $member = $memberRepo->findOneBy(['id' => $memberId]);
                $member->setManagementState(Member::UnmanagementStateManaged);
                // TODO: Check if the expiry date is already set
                $member->setExpiry(new DateTime());

                $updatedMembers[] = $member;
            }
        }

        return $members + $updatedMembers;


        // find existing extranet member
        // if no member, then flag insert
        // loop keys
        //   if insert, then set and add to change set
        //   if update, then compare and add to change set
        // if insert, then do insert
        // if update and changeset, then commit 
        // if update and no changeset, then do nothing
        // capture id of member
        // find existing member, regoID
        // if no member, then check based on name/dob
        // if no member, then flag insert
        // loop keys
        //   if insert, then set and add to change set
        //   if update, then compare and add to change set
        // set managementState to managed and add to changeset if changed
        // set expiry to null and add to changeset if changed

        // find existing extranet contact
        // if no contact, then flag insert
        // loop keys
        //   if insert, then set and add to change set
        //   if update, then compare and add to change set
        // if insert, then do insert
        // if update and changeset, then commit 
        // if update and no changeset, then do nothing
        // capture id of contact
        // find existing contact, parentID, csMemberID
        // if no contact, then check based on name/relationship
        // if no contact, then flag insert
        // loop keys
        //   if insert, then set and add to change set
        //   if update, then compare and add to change set
        // set managementState to managed and add to changeset if changed
        // set expiry to null and add to changeset if changed
        // if insert, then do insert
        // if update and changeset, then commit 
        // if update and no changeset, then do nothing
        // capture id of contact

        // subject contacts, csMemberId
        // compare ids of processed, vs not processed
        // loop
        //   if not processed, then set to unmanaged and expiry        

        // find existing extranet subsidiary
        // if no subsidiary, then flag insert
        // loop keys
        //   if insert, then set and add to change set
        //   if update, then compare and add to change set
        // if insert, then do insert
        // if update and changeset, then commit 
        // if update and no changeset, then do nothing
        // capture id of subsidiary

        // add to member role list

        // find existing role, source, reference, csMemberID
        // if no role, then flag insert
        // loop keys
        //   if insert, then set and add to change set
        //   if update, then compare and add to change set
        // set managementState to managed and add to changeset if changed
        // set expiry to null and add to changeset if changed
        // if insert, then do insert
        // if update and changeset, then commit 
        // if update and no changeset, then do nothing
        // capture id of role

        // compare ids of processed, vs not processed
        // loop
        //   if not processed, then set to unmanaged and expiry

        // if insert, then do insert
        // if update and changeset, then commit 
        // if update and no changeset, then do nothing
        // capture id of member


        // subject members
        // compare ids of processed, vs not processed
        // loop
        //   if not processed, then set to unmanaged and expiry
    }
}
