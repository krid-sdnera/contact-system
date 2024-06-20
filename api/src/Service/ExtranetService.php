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
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var Stopwatch
     */
    private $stopwatch;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var ExtranetMembers
     */
    private $extranetMembers;



    private $_useCache = false;
    private $credentials = [
        'username' => '',
        'password' => ''
    ];

    /**
     * @var HttpClientInterface
     */
    private $client;

    private $extranetMembersArray = [];

    public function __construct(
        EntityManagerInterface $entityManager,
        Stopwatch $stopwatch,
        LoggerInterface $extranetLogger,
        ExtranetMembers $extranetMembers
    ) {
        $this->em = $entityManager;
        $this->stopwatch = $stopwatch;
        $this->logger = $extranetLogger;
        $this->extranetMembers = $extranetMembers;
    }

    public function setCredentials($username, $password): self
    {
        $this->extranetMembers->setCredentials($username, $password);

        return $this;
    }

    public function useCache(bool $cache = false)
    {

        $this->extranetMembers->useCache($cache);

        $this->_useCache = $cache;
        return $this;
    }

    public function setClient(HttpClientInterface $client)
    {
        $this->client = $client;
        $this->extranetMembers->setClient($client);
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
        $membersToPersist = $this->unmanageEntities($convertedExtranetEntities);
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
        foreach ($this->extranetMembersArray as $membershipNumber => $extranetMember) {
            /** @var Member */
            $member = Member::fromExtranetMember($extranetMember);
            $members[] = $member;
            $event = $this->stopwatch->lap('convert-record');
            $this->logger->debug(
                $this->loopLoggerHelper('convert-record', count($this->extranetMembersArray), ['lap' => true])
            );
        }

        $this->stopwatch->stop('convert-record');
        $this->logger->debug(
            $this->loopLoggerHelper('convert-record', count($this->extranetMembersArray))
        );

        return $members;
    }

    private function getExtranetData()
    {
        $this->stopwatch->start('fetch-data-from-extranet');
        $this->extranetMembersArray = $this->extranetMembers->getExtranetMembers();
        $this->stopwatch->stop('fetch-data-from-extranet');

        $this->logger->debug(
            $this->loopLoggerHelper('fetch-data-from-extranet', count($this->extranetMembersArray))
        );

        $this->logger->info("Extranet member data dumped");
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
        $entityCount = max($entityCount, 1);

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
