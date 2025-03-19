<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use DateTime;
use DateTimeInterface;

use Exception;
use Doctrine\ORM\EntityManagerInterface;
use OpenAPI\Server\Model\AddressData;
use OpenAPI\Server\Model\MemberOverrideData;
use OpenAPI\Server\Model\MemberData;
use OpenAPI\Server\Model\MemberMetaInviteData;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberRepository")
 */
class Member
{

    const DefaultManagementState = 'unmanaged';
    const DefaultState = 'enabled';
    const DefaultOverrides = [];

    const ManagementStateManaged = 'managed';
    const ManagementStateUnmanaged = 'unmanaged';

    /**
     * @var EntityManagerInterface
     */
    private static $entityManager;
    /**
     * @var LoggerInterface
     */
    private static $logger;

    public static function setEntityManager(EntityManagerInterface $entityManager)
    {
        self::$entityManager = $entityManager;
    }

    public static function setLogger(LoggerInterface $logger)
    {
        self::$logger = $logger;
    }

    public static function fromExtranetMember(ExtranetMember $extranetMember)
    {

        if (empty(self::$entityManager) || empty(self::$logger)) {
            throw new Exception('Missing entity manager or logger in member entity');
        }

        $logPrefix = "[member extranet={$extranetMember->getMembershipNumber()}]";

        /** @var MemberRepository */
        $memberRepo = self::$entityManager->getRepository(self::class);

        self::$logger->info("{$logPrefix} Checking by membershipNumber");
        // Look for for member by membershipNumber
        /** @var Member */
        $member = $memberRepo->findOneBy([
            'membershipNumber' => $extranetMember->getMembershipNumber()
        ]);

        if (!$member) {
            self::$logger->info("{$logPrefix} Not found by membershipNumber, checking by name");
            // Attempt to match up with an existing record
            $member = $memberRepo->createQueryBuilder('m')
                ->where("lower(m.firstname) LIKE :firstname")
                ->andWhere("lower(m.lastname) LIKE :lastname")
                ->andWhere("m.dateOfBirth = :dateOfBirth")
                ->setParameter("firstname", '%' . strtolower(addcslashes($extranetMember->getFirstname(), '%_')) . '%')
                ->setParameter("lastname", '%' . strtolower(addcslashes($extranetMember->getLastname(), '%_')) . '%')
                ->setParameter("dateOfBirth", $extranetMember->getDateOfBirth())
                ->getQuery()
                ->getOneOrNullResult();
        }

        if (!$member) {
            $memberToString = "[member firstname={$extranetMember->getFirstname()} lastname={$extranetMember->getLastname()}]";
            self::$logger->notice("{$logPrefix} Not found by name, creating {$memberToString}");
            // Still no member matched. Let's create one.
            $member = new self();
            $member->setState(self::DefaultState);
        }

        $_loggableId = $member->getId() ? $member->getId() : 'known after creation';
        self::$logger->debug("{$logPrefix} Entity loaded at id: {$_loggableId}");

        // Update name fields
        if ($member->overridable('firstname')) {
            $member->setFirstname($extranetMember->getFirstname());
        }
        if ($member->overridable('nickname')) {
            $member->setNickname($extranetMember->getNickname());
        }
        if ($member->overridable('lastname')) {
            $member->setLastname($extranetMember->getLastname());
        }
        if ($member->overridable('dateOfBirth')) {
            $extranetDateOfBirth = new DateTime($extranetMember->getDateOfBirth());

            if (!$member->getDateOfBirth()) {
                $member->setDateOfBirth($extranetDateOfBirth);
            } else {
                $firstDate = $member->getDateOfBirth()->format('Y-m-d');
                $secondDate = $extranetDateOfBirth->format('Y-m-d');

                if ($firstDate != $secondDate) {
                    $member->setDateOfBirth($extranetDateOfBirth);
                }
            }
        }
        if ($member->overridable('gender')) {
            $member->setGender($extranetMember->getGender());
        }
        if ($member->overridable('email')) {
            $member->setEmail($extranetMember->getEmail());
        }

        // Update address        
        if ($member->overridable('address')) {
            $member->setAddress(
                array(
                    'street1' => $extranetMember->getHomeAddress(),
                    'street2' => '',
                    'city' => $extranetMember->getHomeSuburb(),
                    'state' => $extranetMember->getHomeState(),
                    'postcode' => $extranetMember->getHomePostcode(),
                )
            );
        }

        // Update contact details
        if ($member->overridable('phoneHome')) {
            $member->setPhoneHome($extranetMember->getHomephone());
        }
        if ($member->overridable('phoneWork')) {
            $member->setPhoneWork($extranetMember->getWorkPhone());
        }
        if ($member->overridable('phoneMobile')) {
            $member->setPhoneMobile($extranetMember->getMobile());
        }

        // Additional invitation data.
        // If the extranet record has changed from being generated from
        // and invite (and therefore the invite meta is blank)
        // this is fine because we want the db to have the invite data blanked.
        $member->setMetaInvite($extranetMember->getMetaInvite());

        // Always: Update school details
        $member->setSchoolName($extranetMember->getSchoolName());
        $member->setSchoolYearLevel($extranetMember->getSchoolYearLevel());

        $member->setMembershipUpdateLink($extranetMember->getMembershipUpdateLink());
        $member->setAutoUpgradeEnabled($extranetMember->getAutoUpgradeEnabled());

        self::$logger->info("{$logPrefix} Always manage member");

        // Always do these fields.
        $member->setMembershipNumber($extranetMember->getMembershipNumber());
        $member->setManagementState(self::ManagementStateManaged);
        $member->setExpiry(null);
        // Do not update `state`.

        // Persist member row before trying to create any referencing rows.
        self::$entityManager->persist($member);
        self::$entityManager->flush();

        self::$logger->info("{$logPrefix} Generating roles");
        $extranetRoles = Member::GenerateExpectedRole($extranetMember);

        /**
         * Roles
         */
        $extranetRoleRelationshipsConsidered = [];
        foreach ($extranetRoles as $i => $extranetRole) {
            $relatioshipEntity = MemberRole::fromExtranetRole($member, $extranetRole);

            // Add this role, no action if already assigned.
            $member->addRole($relatioshipEntity);

            if (self::$entityManager->contains($relatioshipEntity)) {
                $extranetRoleRelationshipsConsidered[] = $relatioshipEntity->getId();
            }
        }

        foreach ($member->getRoles() as $i => $relatioshipEntity) {
            if (!self::$entityManager->contains($relatioshipEntity)) {
                // This is a new role
                continue;
            }
            if (in_array($relatioshipEntity->getId(), $extranetRoleRelationshipsConsidered)) {
                // Yes this role is assigned to the member
                continue;
            }

            self::$logger->info("{$logPrefix} Unmanaging role {$relatioshipEntity->getId()} because !isNew or isAssigned");

            // No this role is not in extranet
            $relatioshipEntity->setManagementState(MemberRole::ManagementStateUnmanaged);

            if ($relatioshipEntity->getExpiry() === null) {
                $relatioshipEntity->setExpiry(new DateTime());
            }
        }

        /**
         * Contacts
         */
        $extranetContactsConsidered = [];
        foreach ($extranetMember->getContacts() as $i => $extranetContact) {
            // Get new or existing contact.
            $contact = Contact::fromExtranetContact($extranetContact);

            // Add this contact, no action if already assigned.
            $member->addContact($contact);

            if (self::$entityManager->contains($contact)) {
                $extranetContactsConsidered[] = $contact->getId();
            }
        }

        foreach ($member->getContacts() as $i => $contact) {
            if (!self::$entityManager->contains($contact)) {
                // This is a new contact
                continue;
            }
            if (in_array($contact->getId(), $extranetContactsConsidered)) {
                // Yes this contact is assigned to the member
                continue;
            }

            self::$logger->info("{$logPrefix} Unmanaging contact {$contact->getId()} because !isNew or isAssigned");

            // No this contact is not in extranet
            $contact->setManagementState(Contact::ManagementStateUnmanaged);
            if ($contact->getExpiry() === null) {
                $contact->setExpiry(new DateTime());
            }
        }

        return $member;
    }

    public function overridable(string $overrideKey)
    {
        $overrides = $this->getOverrides();

        // Check to see if there is an override defined for this field.
        $hasOverride = (isset($overrides[$overrideKey]) && $overrides[$overrideKey] === true);

        // If there is an override set up. Then this field can not be overridden.
        return !$hasOverride;
    }

    public static function GenerateExpectedRole(ExtranetMember $extranetMember): array
    {
        $logPrefix = "[member extranet={$extranetMember->getMembershipNumber()}] [role]";

        // Build expected roles.
        $roles = [];

        $youthClassIds = [
            'JOEY',
            'CUB',
            'SCOUT',
            'VENT',
            'ROVER'
        ];

        // Special handling for 15th essendon sea scouts
        $extranetMember->setGroupName(str_replace(' SEA SCOUTS', '', $extranetMember->getGroupName()));

        foreach ($extranetMember->getRoleStrings() as $i => $roleString) {
            $stringParts = explode(":", $roleString);
            $origin = $stringParts[0];
            $roleNames = $stringParts[1];
            $roleNameParts = explode(",", $roleNames);

            self::$logger->info("{$logPrefix} Generating role: {$roleString}");

            foreach ($roleNameParts as $i => $roleName) {
                $role = trim($roleName);

                if ($origin === 'ClassID') {

                    if (in_array($extranetMember->getClassId(), $youthClassIds)) {
                        self::$logger->info("{$logPrefix} Generating role: {$origin} {$role}");
                        $roles[] = new ExtranetRole(
                            'Youth',
                            'youth-classIdYouth',
                            $extranetMember->getClassId(),
                            $extranetMember->getClassId(),
                            $extranetMember->getSectionName(),
                            $extranetMember->getSectionId(),
                            $extranetMember->getGroupName(),
                            $extranetMember->getGroupId()
                        );
                    } elseif ($extranetMember->getClassId() === 'AH') {
                        self::$logger->info("{$logPrefix} Generating role: {$origin} {$role}");
                        $roles[] = new ExtranetRole(
                            'Adult Helper',
                            'adult-helper-classIdAdultHelper',
                            $extranetMember->getClassId(),
                            $extranetMember->getClassId(),
                            $extranetMember->getGroupName(),
                            $extranetMember->getGroupId(),
                            $extranetMember->getGroupName(),
                            $extranetMember->getGroupId()
                        );
                    }
                    // Else they are a leader and handled by their role value.

                } elseif ($origin === 'Role') {
                    self::$logger->info("{$logPrefix} Generating role: {$origin} {$role}");
                    preg_match(
                        '/(?:A-Z\s)?(JOEY SCOUT|CUB SCOUT|SCOUT|VENTURER|ROVER|GROUP)\s+(?:LDR|LEADER)/',
                        $role,
                        $matches
                    );

                    if (count($matches) == 2) {
                        $normalisedSection = $matches[1];
                        //Remove {CUB}" SCOUT" & {JOEY}" SCOUT"
                        $normalisedSection = preg_replace('/(.+?)(?: SCOUT)?/', '$1', $normalisedSection);
                        //Remove {VENT}"URER"
                        $normalisedSection = preg_replace('/(.+?)(?:URER)?/', '$1', $normalisedSection);
                    } else {
                        $normalisedSection = 'GROUP';
                    }

                    // Generate sections
                    $nameMapping = array(
                        'JOEY' => '-JOEY SCOUT MOB 1',
                        'CUB' => '-CUB SCOUT PACK 1',
                        'SCOUT' => '-SCOUT TROOP 1',
                        'VENT' => '-VENTURER UNIT 1',
                        'ROVER' => '-ROVER CREW 1',
                        'GROUP' => ''
                    );
                    $idMapping = array(
                        'JOEY' => 'M1',
                        'CUB' => 'P1',
                        'SCOUT' => 'T1',
                        'VENT' => 'U1',
                        'ROVER' => 'C1',
                        'GROUP' => ''
                    );

                    $sectionName = $extranetMember->getGroupName() . $nameMapping[$normalisedSection];
                    $sectionId = $extranetMember->getGroupId() . $idMapping[$normalisedSection];

                    $roles[] = new ExtranetRole(
                        ucwords(strtolower($role)),
                        str_replace(' ', '-', strtolower($role)) . '-classIdLeader',
                        $extranetMember->getClassId(),
                        $normalisedSection,
                        $sectionName,
                        $sectionId,
                        $extranetMember->getGroupName(),
                        $extranetMember->getGroupId()
                    );

                } elseif ($origin === 'Position') {
                    self::$logger->info("{$logPrefix} Generating role: {$origin} {$role}");

                    // Convert Position to Roles
                    $roles[] = new ExtranetRole(
                        $role,
                        str_replace(' ', '-', strtolower($role)) . '-classIdAdultSupporter',
                        $extranetMember->getClassId(),
                        $extranetMember->getClassId(),
                        $extranetMember->getGroupName(),
                        $extranetMember->getGroupId(),
                        $extranetMember->getGroupName(),
                        $extranetMember->getGroupId()
                    );

                }
            }
        }

        // Convert Subsidiary Sections to Roles
        $subSections = $extranetMember->getSubsidiarySections();
        foreach ($subSections as $i => $section) {
            self::$logger->info("{$logPrefix} Generating role: subsidiarySection {$i}: {$section['SectionName']}");
            $roles[] = new ExtranetRole(
                'Youth',
                'youth-subsidiarySection',
                'Subsidary',
                'Subsidary',
                $section['SectionName'],
                $section['SectionID'],
                $section['SectionName'],
                $section['SectionID']
            );
        }

        return $roles;
    }

    public function toMemberData(): MemberData
    {
        $arrayData = [
            'id' => $this->getId(),
            'state' => $this->getState(),
            'managementState' => $this->getManagementState(),
            'expiry' => ($this->getExpiry()) ? $this->getExpiry()->format(DateTimeInterface::ISO8601) : null,
            'firstname' => $this->getFirstname(),
            'nickname' => $this->getNickname(),
            'lastname' => $this->getLastname(),
            'dateOfBirth' => $this->getDateOfBirth(),
            'gender' => $this->getGender(),
            'membershipNumber' => $this->getMembershipNumber(),
            'address' => new AddressData($this->getAddress()),
            'phoneHome' => $this->getPhoneHome(),
            'phoneWork' => $this->getPhoneWork(),
            'phoneMobile' => $this->getPhoneMobile(),
            'email' => $this->getEmail(),
            'schoolName' => $this->getSchoolName(),
            'schoolYearLevel' => $this->getSchoolYearLevel(),
            'overrides' => new MemberOverrideData($this->getOverrides()),
            'membershipUpdateLink' => $this->getMembershipUpdateLink(),
            'autoUpgradeEnabled' => $this->getAutoUpgradeEnabled(),
            'metaInvite' => new MemberMetaInviteData($this->getMetaInvite()),
        ];

        $data = new MemberData($arrayData);

        return $data;
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $membershipNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nickname;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="json")
     */
    private $address = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phoneHome;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phoneMobile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phoneWork;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $schoolName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $schoolYearLevel;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MemberRole", mappedBy="member", cascade={"persist"})
     * @MaxDepth(1)
     * @Ignore()
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contact", mappedBy="member", cascade={"persist"})
     * @MaxDepth(1)
     * @Ignore()
     */
    private $contacts;

    /**
     * @ORM\Column(type="string", length=255, options={"default": "enabled"})
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255, options={"default": "unmanaged"})
     */
    private $managementState;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $expiry;

    /**
     * @ORM\Column(type="json")
     */
    private $overrides = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $metaInvite = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $membershipUpdateLink;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $autoUpgradeEnabled;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->contacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getAddress(): ?array
    {
        return $this->address;
    }

    public function setAddress(array $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getMembershipNumber(): ?string
    {
        return $this->membershipNumber;
    }

    public function setMembershipNumber(?string $membershipNumber): self
    {
        $this->membershipNumber = $membershipNumber;

        return $this;
    }

    public function getPhoneHome(): ?string
    {
        return $this->phoneHome;
    }

    public function setPhoneHome(?string $phoneHome): self
    {
        $this->phoneHome = $phoneHome;

        return $this;
    }

    public function getPhoneMobile(): ?string
    {
        return $this->phoneMobile;
    }

    public function setPhoneMobile(?string $phoneMobile): self
    {
        $this->phoneMobile = $phoneMobile;

        return $this;
    }

    public function getPhoneWork(): ?string
    {
        return $this->phoneWork;
    }

    public function setPhoneWork(?string $phoneWork): self
    {
        $this->phoneWork = $phoneWork;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|MemberRole[]
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(MemberRole $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole(MemberRole $role): self
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
        }

        return $this;
    }

    /**
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setMember($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->contains($contact)) {
            $this->contacts->removeElement($contact);
            // set the owning side to null (unless already changed)
            if ($contact->getMember() === $this) {
                $contact->setMember(null);
            }
        }

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getManagementState(): ?string
    {
        return $this->managementState;
    }

    public function setManagementState(string $managementState): self
    {
        $this->managementState = $managementState;

        return $this;
    }

    public function getExpiry(): ?\DateTimeInterface
    {
        return $this->expiry;
    }

    public function setExpiry(?\DateTimeInterface $expiry): self
    {
        $this->expiry = $expiry;

        return $this;
    }

    public function getOverrides(): ?array
    {
        return $this->overrides;
    }

    public function setOverrides(array $overrides): self
    {
        $this->overrides = $overrides;

        return $this;
    }

    public function getSchoolName(): ?string
    {
        return $this->schoolName;
    }

    public function setSchoolName(?string $schoolName): self
    {
        $this->schoolName = $schoolName;

        return $this;
    }

    public function getSchoolYearLevel(): ?string
    {
        return $this->schoolYearLevel;
    }

    public function setSchoolYearLevel(?string $schoolYearLevel): self
    {
        $this->schoolYearLevel = $schoolYearLevel;

        return $this;
    }

    public function getMetaInvite(): ?array
    {
        return $this->metaInvite;
    }

    public function setMetaInvite(?array $metaInvite): self
    {
        $this->metaInvite = $metaInvite;

        return $this;
    }

    public function getMembershipUpdateLink(): string
    {
        return ($this->membershipUpdateLink) ?: '';
    }

    public function setMembershipUpdateLink($membershipUpdateLink): self
    {
        $this->membershipUpdateLink = $membershipUpdateLink;

        return $this;
    }

    public function getAutoUpgradeEnabled(): bool
    {
        return ($this->autoUpgradeEnabled) ?: false;
    }

    public function setAutoUpgradeEnabled($autoUpgradeEnabled): self
    {
        $this->autoUpgradeEnabled = $autoUpgradeEnabled;

        return $this;
    }
}
