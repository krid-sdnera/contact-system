<?php

namespace App\Service;

use Exception;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use Psr\Log\LoggerInterface;

use League\Csv\Reader;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\ExtranetMember;
use App\Entity\ExtranetContact;

class ExtranetMembers
{
    /**
     * @var Stopwatch
     */
    private $stopwatch;

    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var ExtranetLogin
     */
    private $extranetLogin;
    /**
     * @var HttpClientInterface
     */
    private $client;

    private $extranetMembers = [];

    // I don't really want to assume but... VicScouts likes javascript ambiguities
    const MemberContactHeaders = ['Relationship', 'Title', 'Firstname', 'Surname', 'Preferedname', 'Occupation', 'Contact', 'Address', 'PrimaryContact'];


    public function __construct(
        Stopwatch $stopwatch,
        EntityManagerInterface $extranetLogger,
        ExtranetLogin $extranetLogin,

    ) {
        $this->stopwatch = $stopwatch;
        $this->logger = $extranetLogger;
        $this->extranetLogin = $extranetLogin;
    }


    private $_useCache = false;
    private $cacheDirectory;

    public function setCacheDirectory($cacheDirectory): self
    {
        $this->cacheDirectory = $cacheDirectory;
        return $this;
    }

    public function useCache(bool $cache = false)
    {
        $this->_useCache = $cache;
        return $this;
    }


    public function setCredentials($username, $password): self
    {
        $this->extranetLogin->setCredentials($username, $password);

        return $this;
    }

    public function setClient(HttpClientInterface $client)
    {
        $this->client = $client;
    }


    public function getExtranetMembers()
    {

        $this->setClient($this->extranetLogin->doExtranetLogin());

        $this->getExtranetReport('total_grand');
        $this->getExtranetReport('as');

        $this->getExtranetInvitation('active');
        $this->getExtranetInvitation('approving');
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
            if ($record['RegID'] !== '8106128') {
                continue;
            }


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

        // if (isset($this->extranetMembers[$extranetMember->getMembershipNumber()])) {
        //     // hol' up.
        //     // This member was processed in a previous report set.
        //     // Merge and discard new record.
        //     $existingExtranetMember = $this->extranetMembers[$extranetMember->getMembershipNumber()];

        //     $existingExtranetMember->merge($extranetMember);
        // } else {
        //     $this->extranetMembers[$extranetMember->getMembershipNumber()] = $extranetMember;
        // }

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
                '|<td>(.+?) \((.+?)\).*?</td><td>[\d-]+?</td>|',
                $matches[1],
                $matchGroups,
                PREG_SET_ORDER
            );

            foreach ($matchGroups as $i => $group) {
                $extranetMember->addSubsidiarySection([
                    'SectionName' => $group[1],
                    'SectionID' => $group[2]
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

            $this->extranetMembers[$extranetMember->getMembershipNumber()] = $extranetMember;
        }
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


