<?php

namespace App\Service;

use Exception;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use Psr\Log\LoggerInterface;

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
    /**
     * @var Stopwatch
     */
    private $stopwatch;
    /**
     * @var LoggerInterface
     */
    private $logger;

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

    public function __construct(EntityManagerInterface $entityManager, Stopwatch $stopwatch)
    {
        $this->em = $entityManager;
        $this->stopwatch = $stopwatch;
    }

    public function setLogger($logger): self
    {
        $this->logger = $logger;
        return $this;
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

        $this->stopwatch->openSection();

        $this->getExtranetData();

        Member::setEntityManager($this->em);
        Contact::setEntityManager($this->em);
        MemberRole::setEntityManager($this->em);
        Role::setEntityManager($this->em);
        Section::setEntityManager($this->em);
        ScoutGroup::setEntityManager($this->em);

        Member::setLogger($this->logger);
        Contact::setLogger($this->logger);
        MemberRole::setLogger($this->logger);
        Role::setLogger($this->logger);
        Section::setLogger($this->logger);
        ScoutGroup::setLogger($this->logger);

        $convertedExtranetEntities = $this->convertExtranetObjectsToDBEntities();

        // TODO: Rename to something like `difflocalandextranettogetalistofupdates()`
        $this->stopwatch->start('analyse-management-state');
        $membersToPersist =  $this->unmanageEntities($convertedExtranetEntities);
        $this->stopwatch->stop('analyse-management-state');
        $this->logger->debug(
            $this->loopLoggerHelper('analyse-management-state', 1)
        );

        $this->stopwatch->start('persist-data');
        foreach ($membersToPersist as $i => $member) {
            $this->em->persist($member);
        }

        $this->em->flush();
        $this->stopwatch->stop('persist-data');
        $this->logger->debug(
            $this->loopLoggerHelper('persist-data', count($membersToPersist))
        );

        $this->stopwatch->stopSection('extranet-sync');
    }

    private function convertExtranetObjectsToDBEntities()
    {
        $this->stopwatch->start('convert-record');

        /** @var Member[] */
        $members = [];
        foreach ($this->extranetMembers as $i => $extranetMember) {
            /** @var Member */
            $member = Member::fromExtranetMember($extranetMember);
            $members[] = $member;
            $event = $this->stopwatch->lap('convert-record');
            $this->logger->debug(
                $this->loopLoggerHelper('convert-record', count($this->extranetMembers), ['lap' => true])
            );
        }

        $this->stopwatch->stop('convert-record');
        $this->logger->debug(
            $this->loopLoggerHelper('convert-record', count($this->extranetMembers))
        );

        return  $members;
    }

    private function getExtranetData()
    {
        if ($this->_useCache) {
            $this->stopwatch->start('fetch-data-from-cache');
            $this->logger->info('Using cache data');

            $data = json_decode(file_get_contents($this->cacheDirectory . 'extranet-data.json'), true);

            $this->extranetMembers = array_map(
                function ($member) {
                    return ExtranetMember::fromArray($member);
                },
                $data
            );

            $this->logger->info('Cache data loaded successfully');
            $this->stopwatch->stop('fetch-data-from-cache');
            $this->logger->debug(
                $this->loopLoggerHelper('fetch-data-from-cache', count($this->extranetMembers))
            );

            return;
        }

        $this->stopwatch->start('fetch-data-from-extranet');
        $this->setClient(self::HttpClientFactory());

        $this->doExtranetLogin();

        $this->getExtranetReport('total_grand');
        $this->getExtranetReport('as');

        $this->getExtranetInvitation('active');
        $this->getExtranetInvitation('approving');

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
        $this->stopwatch->stop('fetch-data-from-extranet');
        $this->logger->info("Data cached");

        $this->logger->debug(
            $this->loopLoggerHelper('fetch-data-from-extranet', count($this->extranetMembers))
        );
    }

    private function doExtranetLogin(): void
    {
        $this->stopwatch->start('extranet-login');
        $this->logger->info('Doing login');
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

        $this->do2FANextStep($loginResponse);
        $this->do2FAActionValidate($loginResponse);
        $loginResponse = $this->do2FAConfirm($loginResponse);

        if ($this->isExtranetCensusActive($loginResponse)) {
            $this->checkExtranetLoginCensus();
        } else if ($this->isExtranetInsuranceActive($loginResponse)) {
            $this->checkExtranetLoginInsurance();
        } else if ($this->isExtranetPasswordExpiryActive($loginResponse)) {
            $this->checkExtranetLoginPasswordExpiry();
        } else {
            $this->checkExtranetLoginSuccessfull($loginResponse);
        }

        $this->logger->info('Logged in');
        $this->stopwatch->stop('extranet-login');
        $this->logger->debug(
            $this->loopLoggerHelper('extranet-login', 1)
        );
    }

    private function do2FANextStep(ResponseInterface $response): void
    {
        $this->logger->info('Checking 2FA next step');
        $content = $response->getContent();

        // Check that the 2FA next step is exposed.
        preg_match(
            '|<input type="hidden" name="nextAuthStep" id="nextAuthStep" value="1">|',
            $content,
            $matches
        );

        if (count($matches) !== 1) {
            $this->logger->info('Performing 2FA next step');

            $_2fa_next_step = $this->client->request(
                'POST',
                '/portal/twoFactorAuth.php',
                [
                    'body' => [
                        "username" => $this->credentials['username'],
                        "password" => $this->credentials['password'],
                        "nextAuthStep" => "1"
                    ]
                ]
            );
        }
    }

    private function do2FAActionValidate(ResponseInterface $response): void
    {
        $this->logger->info('Sending 2FA request');
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
    }

    private function do2FAConfirm(ResponseInterface $response): ResponseInterface
    {
        $this->logger->info('Confirming 2FA request with extranet');
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

        return $loginResponse;
    }

    private function isExtranetCensusActive(ResponseInterface $response): bool
    {
        $this->logger->info('Checking login for census');
        $content = $response->getContent();

        // Check for the existance of the census style redirect
        preg_match(
            '|<body onLoad="javascript:window.location.replace\(\'(/portal/Interface/MSUCensus/CensusCount/pfcConfirmReport.php)\'\)"></body>|',
            $content,
            $matches
        );

        if (count($matches) !== 2) {
            $this->logger->info("Census not active");
            return false;
        }
        return true;
    }

    private function checkExtranetLoginCensus(): void
    {
        // Fetch Census Report page
        $censusResponse = $this->client->request('GET', '/portal/Interface/MSUCensus/CensusCount/pfcConfirmReport.php');

        // Check for the existance of the successful login style redirect after census.
        preg_match(
            '|window.location.replace\(\'\..\/..\/mainPage.php\?var=(\d+)\'\)|',
            $censusResponse->getContent(),
            $matches
        );

        if (count($matches) === 2) {
            // Login successful
            return;
        }

        // Check that there is a verify button
        preg_match(
            "|onclick=\"verify\(false,'(\d+)','(redirect)'\)\"|",
            $censusResponse->getContent(),
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

        $this->logger->info('Checking login for success');
        $content = $censusConfirmResponse->getContent();

        // Check for the existance of the successful login style redirect after census.
        preg_match(
            '|window.location.replace\(\'\..\/..\/mainPage.php\?var=(\d+)\'\)|',
            $content,
            $matches
        );

        if (count($matches) !== 2) {
            // Unable to login
            throw new Exception('Unable to Login! Check the credentials: case census');
        }
    }

    private function isExtranetInsuranceActive(ResponseInterface $response): bool
    {
        $this->logger->info('Checking login for insurance');
        $content = $response->getContent();

        // Check for the existance of the insurance style redirect
        preg_match(
            '|<body onLoad="javascript:window.location.replace\(\'(/portal/Controllers/controller_extranet\.php\?request\=Insurance\.Questionnaire\.Open\&FromLogin\=yes)\'\)"></body>|',
            $content,
            $matches
        );

        if (count($matches) !== 2) {
            $this->logger->info("Insurance not active");
            return false;
        }
        return true;
    }

    private function checkExtranetLoginInsurance(): void
    {
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
            $insuranceResponse->getContent(),
            $matches
        );

        if (count($matches) !== 2) {
            // There was no verify button
            throw new Exception('Insurance active: verify button not found.');
        }
    }

    private function isExtranetPasswordExpiryActive(ResponseInterface $response): bool
    {
        $this->logger->info('Checking login for password expiry');
        $content = $response->getContent();

        // Check for the existance of the password expiry style redirect
        preg_match(
            '|<title> Password expire in \d+ days? <\/title>|',
            $content,
            $matches
        );

        if (count($matches) !== 2) {
            // Password has not expired
            return false;
        }
        return true;
    }

    private function checkExtranetLoginPasswordExpiry(): void
    {
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
            $passwordChangeResponse->getContent(),
            $matches
        );

        if (count($matches) !== 2) {
            // Unable to update password
            throw new Exception('Password expiring: cannot update password');
        }

        $this->logger->notice('Password updated successfully. Your password will expire in ' . $matches[1] . ' days.');

        preg_match(
            '|window\.location\.replace\(\'/portal/Interface/mainPage\.php\?var=(\d+)\'\)|',
            $passwordChangeResponse->getContent(),
            $matches
        );

        if (count($matches) !== 2) {
            // Unable to login
            throw new Exception('Unable to Login! Check the credentials: case pwd');
        }
    }

    private function checkExtranetLoginSuccessfull(ResponseInterface $response): void
    {
        $this->logger->info('Checking login for success');
        $content = $response->getContent();

        // Check for the existance of the successful login style redirect
        preg_match(
            '|<body onLoad="javascript:window.location.replace\(\'/portal/Interface/mainPage.php\?var=(\d+)\'\)"></body>|',
            $content,
            $matches
        );

        if (count($matches) !== 2) {
            // Unable to login
            throw new Exception('Unable to Login! Check the credentials: case basic');
        }
    }

    public function getExtranetReport($reportName)
    {
        $this->stopwatch->start('fetch-report-' . $reportName);
        $this->logger->info('Begin report ' . $reportName);
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
        $expectedCSVRowCount = substr_count($content, "\n") - 1; // minus the header

        // Update Cache
        file_put_contents(
            $this->cacheDirectory . $reportName . '.csv',
            $content
        );

        $csv = Reader::createFromString($content);
        $csv->setHeaderOffset(0);

        // $header = $csv->getHeader();
        $records = $csv->getRecords();
        $this->stopwatch->stop('fetch-report-' . $reportName);
        $this->logger->debug(
            $this->loopLoggerHelper('fetch-report-' . $reportName, 1)
        );

        $this->stopwatch->start('fetch-record');
        foreach ($records as $i => $record) {
            $this->processReportRecord($record);
            $this->stopwatch->lap('fetch-record');
            $this->logger->debug(
                $this->loopLoggerHelper('fetch-record', $expectedCSVRowCount, ["lap" => true, "approx" => true])
            );
        }

        $this->stopwatch->stop('fetch-record');
        $this->logger->debug(
            $this->loopLoggerHelper('fetch-record', count($this->extranetMembers))
        );
    }

    private function processReportRecord($record)
    {
        $this->logger->info('Processing ' . $record['RegID']);

        $extranetMember = ExtranetMember::fromExtranetCsv($record);

        $this->getMemberDetailPage($extranetMember);
        $this->getMemberEditPage($extranetMember);
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

    private function getMemberEditPage(ExtranetMember $extranetMember)
    {
        // Downloading: Member Edit Page
        $response = $this->client->request('POST', '/portal/Interface/Report/editMemDetail.php', [
            "body" => [
                "CourseID" => "",
                "RegID" => $extranetMember->getMembershipNumber(),
                "mainWindow" => "showMemDetail.php"
            ]
        ]);
        $content = $response->getContent();
        // $this->logger->info($content);
        // Extract the member's auto upgrade status.
        // The HTML is invalid! Attributes use single quotes!
        preg_match(
            "|<input type='radio' name='txtAutoUpgrade' width=\"100\" checked='checked' value='(.)' >|",
            $content,
            $matches
        );
        $checked = (count($matches) === 2) ? $matches[1] : '';
        $autoUpgradeEnabled = $checked === "Y";

        $extranetMember->setAutoUpgradeEnabled($autoUpgradeEnabled);
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

    private function getExtranetInvitation($type)
    {
        $this->logger->info('Begin invitation - ' . $type);
        if ($type === 'active') {
            $response = $this->client->request('GET', '/portal/membership/ajax-get-invitation-list/type/' . $type);
        } else if ($type === 'approving') {
            $response = $this->client->request('GET', '/portal/membership/ajax-get-approval-list/type/' . $type);
        }
        $content = json_decode($response->getContent(), true);

        foreach ($content as $i => $record) {
            $this->logger->info('Processing ' . $record['id']);

            $extranetMember = ExtranetMember::fromExtranetInvitation($record, $type);

            $this->extranetMembers[] = $extranetMember;
        }
    }

    private function unmanageEntities(array $convertedExtranetEntities)
    {

        /** @var MemberRepository */
        $memberRepo = $this->em->getRepository(Member::class);

        // Find all managed members.
        $managedMemberIds = $memberRepo->findIdsBy([
            'managementState' => Member::ManagementStateManaged
        ]);

        // Collate all member IDs.
        // (which are in the extranet export AND
        //  were not created during this run)
        $extranetMembersConsidered = [];
        foreach ($convertedExtranetEntities as $i => $member) {
            // For members which are not persisted at all,
            // (ie. new members) they will not be in the entity manager.
            // This also means they do not need to be considered.
            if ($this->em->contains($member)) {
                $extranetMembersConsidered[] = $member->getId();
            }
        }

        // Check all currently managed memebers.
        // If the member is in the dataset we got from Extranet, all good.
        // Otherwise, they have dropped off the extranet list, so we need to
        // unmanage them.
        $updatedMembers = [];
        foreach ($managedMemberIds as $i => $memberId) {
            // Is this member also in extranet?
            if (in_array($memberId, $extranetMembersConsidered)) {
                // Yes this member is in extranet.
                // Don't change any states.
            } else {
                // No this contact is not in extranet
                /** @var Member */
                $member = $memberRepo->findOneBy(['id' => $memberId]);
                $member->setManagementState(Member::ManagementStateUnmanaged);

                if ($member->getExpiry() === null) {
                    $member->setExpiry(new DateTime());
                }

                $logPrefix = "[member id={$member->getId()}]";

                $memberToString = "[member id={$member->getId()} firstname={$member->getFirstname()} lastname={$member->getLastname()}]";
                $this->logger->notice("{$logPrefix} Unmanaging {$memberToString}");

                foreach ($member->getContacts() as $i => $contact) {
                    $contact->setManagementState(Contact::ManagementStateUnmanaged);
                    if ($contact->getExpiry() === null) {
                        $contactToString = "[contact id={$contact->getId()} firstname={$contact->getFirstname()} lastname={$contact->getLastname()}]";
                        $this->logger->notice("{$logPrefix} Unmanaging {$contactToString}");
                        $contact->setExpiry(new DateTime());
                    }
                }

                foreach ($member->getRoles() as $i => $role) {
                    $role->setManagementState(MemberRole::ManagementStateUnmanaged);
                    if ($role->getExpiry() === null) {
                        $roleToString = "[member-role id={$role->getId()} roleName={$role->getRole()->getName()}]";
                        $this->logger->notice("{$logPrefix} Unmanaging {$roleToString}");
                        $role->setExpiry(new DateTime());
                    }
                }

                $updatedMembers[] = $member;
            }
        }

        return $convertedExtranetEntities + $updatedMembers;


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

    function loopLoggerHelper(string $eventName, int $entityCount, $options = [])
    {
        $event = $this->stopwatch->getEvent($eventName);
        if (isset($options['lap']) && $options['lap'] === true) {
            $period = $event->getPeriods()[count($event->getPeriods()) - 1];
            $lapMemory = $period->getMemory() / 1024 / 1024;
            $lapDuration = $period->getDuration();

            return sprintf(
                '[timings] %s entity index %d/%s%d, current: %.2F MiB - %d ms',
                $eventName,
                count($event->getPeriods()),
                (isset($options['approx']) && $options['approx'] === true) ? '~' : '',
                $entityCount,
                $lapMemory,
                $lapDuration
            );
        }

        $event = $this->stopwatch->getEvent($eventName);
        $memory = $event->getMemory() / 1024 / 1024;
        $duration = $event->getDuration();

        return sprintf(
            '[timings] %s entity count %d, average: %.2F MiB - %d ms total: %.2F MiB - %d ms',
            $eventName,
            $entityCount,
            $memory / $entityCount,
            $duration / $entityCount,
            $memory,
            $duration
        );
    }
}
