<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use DateTime;

use Exception;
use Doctrine\ORM\EntityManagerInterface;
use OpenAPI\Server\Model\AddressData;
use OpenAPI\Server\Model\MemberData;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberRepository")
 */
class Member
{

    const DefaultManagementState = 'unmanaged';
    const DefaultState = 'enabled';
    const DefaultOverrides = [];

    const ManagementStateManaged = 'managed';
    const UnmanagementStateManaged = 'unmanaged';

    private static $entityManager;

    public static function setEntityManager(EntityManagerInterface $entityManager)
    {
        self::$entityManager = $entityManager;
    }

    public static function fromExtranetMember(ExtranetMember $extranetMember)
    {

        if (empty(self::$entityManager)) {
            throw new Exception('Missing entity manager in member entity');
        }

        /** @var MemberRepository */
        $memberRepo = self::$entityManager->getRepository(self::class);

        echo "Processing Member {$extranetMember->getMembershipNumber()}: Checking by membershipNumber" . PHP_EOL;
        // Look for for member by membershipNumber
        /** @var Member */
        $member = $memberRepo->findOneBy([
            'membershipNumber' => $extranetMember->getMembershipNumber()
        ]);

        if (!$member) {
            echo "Processing Member {$extranetMember->getMembershipNumber()}: Not found by membershipNumber, checking by name" . PHP_EOL;
            // Attempt to match up with an existing record
            $member = $memberRepo->createQueryBuilder('m')
                ->where("m.firstname LIKE :firstname")
                ->orWhere("m.firstname LIKE :lastname")
                ->andWhere("m.dateOfBirth = :dateOfBirth")
                ->andWhere("m.managementState = :state")
                ->setParameter("firstname", '%' . addcslashes($extranetMember->getFirstname(), '%_') . '%')
                ->setParameter("lastname", '%' . addcslashes($extranetMember->getLastname(), '%_') . '%')
                ->setParameter("dateOfBirth", $extranetMember->getDateOfBirth())
                ->setParameter("state", 'unmanaged')
                ->getQuery()
                ->getOneOrNullResult();
        }

        if (!$member) {
            echo "Processing Member {$extranetMember->getMembershipNumber()}: Not found by name, creating" . PHP_EOL;
            // Still no member matched. Let's create one.
            $member = new self();
            $member->setState(self::DefaultState);
        }


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
            $member->setDateOfBirth(new DateTime($extranetMember->getDateOfBirth()));
        }
        if ($member->overridable('gender')) {
            $member->setGender($extranetMember->getGender());
        }

        // Update address        
        if ($member->overridable('address')) {
            $member->setAddress(array(
                'street1' => $extranetMember->getHomeAddress(),
                'street2' => '',
                'city' => $extranetMember->getHomeSuburb(),
                'state' => $extranetMember->getHomeState(),
                'postcode' => $extranetMember->getHomePostcode(),
            ));
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
        if ($member->overridable('email')) {
            $member->setEmail($extranetMember->getEmail());
        }

        // Always: Update school details
        $member->setSchoolName($extranetMember->getSchoolName());
        $member->setSchoolYearLevel($extranetMember->getSchoolYearLevel());

        echo "Processing Member {$extranetMember->getMembershipNumber()}: Generating roles" . PHP_EOL;
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

            echo "Processing Member {$extranetMember->getMembershipNumber()}: Unmanaging role {$relatioshipEntity->getId()} because !isNew or isAssigned" . PHP_EOL;

            // No this role is not in extranet
            $relatioshipEntity->setManagementState(MemberRole::UnmanagementStateManaged);
            // TODO: Check if the expiry date is already set
            $relatioshipEntity->setExpiry(new DateTime());
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

            echo "Processing Member {$extranetMember->getMembershipNumber()}: Unmanaging contact {$contact->getId()} because !isNew or isAssigned" . PHP_EOL;

            // No this contact is not in extranet
            $contact->setManagementState(Contact::UnmanagementStateManaged);
            // TODO: Check if the expiry date is already set
            $contact->setExpiry(new DateTime());
        }

        echo "Processing Member {$extranetMember->getMembershipNumber()}: Always manage member" . PHP_EOL;

        // Always do these fields.
        $member->setMembershipNumber($extranetMember->getMembershipNumber());
        $member->setManagementState(self::ManagementStateManaged);
        $member->setExpiry(null);
        // Do not update `state`.

        return $member;
    }

    public function overridable(string $overrideKey)
    {
        $overrides = $this->getOverrides();

        // Check to see if there is an override defined for this field.
        $hasOverride = (isset($overrides[$overrideKey]) && $overrides[$overrideKey] === true);

        // If there is an override set up. Then this field can not be overriden.
        return !$hasOverride;
    }

    public static function GenerateExpectedRole(ExtranetMember $extranetMember): array
    {

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

        if (in_array($extranetMember->getClassId(), $youthClassIds)) {
            echo "Processing Member {$extranetMember->getMembershipNumber()}: Generating role: classIdYouth" . PHP_EOL;
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
        } elseif ($extranetMember->getClassId() === 'LDR') {
            echo "Processing Member {$extranetMember->getMembershipNumber()}: Generating role: classIdLeader" . PHP_EOL;
            preg_match(
                '/(?:A-Z\s)?(JOEY SCOUT|CUB SCOUT|SCOUT|VENTURER|ROVER|GROUP)\s+(?:LDR|LEADER)/',
                $extranetMember->getRole(),
                $matches
            );

            if (count($matches) == 2) {
                $normalisedSection = $matches[1];
                //Remove {CUB}" SCOUT" & {JOEY}" SCOUT"
                $normalisedSection = preg_replace('/(.+?)(?: SCOUT)?/', '$1', $normalisedSection);
                //Remove {VENT}"URER"
                $normalisedSection = preg_replace('/(.+?)(?:URER)?/',   '$1', $normalisedSection);
            } else {
                $normalisedSection = 'GROUP';
            }

            // Generate sections
            $nameMapping = array(
                'JOEY'  => '-JOEY SCOUT MOB',
                'CUB'   => '-CUB SCOUT PACK',
                'SCOUT' => '-SCOUT TROOP',
                'VENT'  => '-VENTURER UNIT',
                'ROVER' => '-ROVER CREW',
                'GROUP' => ''
            );
            $idMapping = array(
                'JOEY'  => 'M',
                'CUB'   => 'P',
                'SCOUT' => 'T',
                'VENT'  => 'U',
                'ROVER' => 'C',
                'GROUP' => ''
            );

            $sectionName = $extranetMember->getGroupName() . $nameMapping[$normalisedSection];
            $sectionId = $extranetMember->getGroupId() . $idMapping[$normalisedSection];

            $roles[] = new ExtranetRole(
                ucwords(strtolower($extranetMember->getRole())),
                str_replace(' ', '-', strtolower($extranetMember->getRole())) . '-classIdLeader',
                $extranetMember->getClassId(),
                $normalisedSection,
                $sectionName,
                $sectionId,
                $extranetMember->getGroupName(),
                $extranetMember->getGroupId()
            );
        } elseif ($extranetMember->getClassId() === 'OB') {
            echo "Processing Member {$extranetMember->getMembershipNumber()}: Generating role: classIdOfficeBearer" . PHP_EOL;
            // Convert Position to Roles
            $positions = $extranetMember->getPosition();

            if ($positions) {
                $positionArray = preg_split('/,\s*/', $positions);

                foreach ($positionArray as $i => $position) {
                    $roles[] = new ExtranetRole(
                        $position,
                        str_replace(' ', '-', strtolower($position)) . '-classIdOfficeBearer',
                        $extranetMember->getClassId(),
                        $extranetMember->getClassId(),
                        $extranetMember->getGroupName(),
                        $extranetMember->getGroupId(),
                        $extranetMember->getGroupName(),
                        $extranetMember->getGroupId()
                    );
                }
            }
        } elseif ($extranetMember->getClassId() === 'AH') {
            echo "Processing Member {$extranetMember->getMembershipNumber()}: Generating role: classIdAdultHelper" . PHP_EOL;
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

        // Convert Subsidiary Sections to Roles
        $subSections = $extranetMember->getSubsidiarySections();
        foreach ($subSections as $i => $section) {
            echo "Processing Member {$extranetMember->getMembershipNumber()}: Generating role: subsidiarySection {$i}: {$section['SectionName']}" . PHP_EOL;
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
            'expiry' => $this->getExpiry(),
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
            // TODO fix this
            // 'membershipUpdateLink' => $this->getMembershipUpdateLink(),
            'roles' => array_map(function ($role) {
                return $role->toMemberRoleData();
            }, iterator_to_array($this->getRoles())),
            'contacts' => array_map(function ($contact) {
                return $contact->toContactData();
            }, iterator_to_array($this->getContacts()))
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
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contact", mappedBy="member", cascade={"persist"})
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
     * @ORM\Column(type="json", options={"default": "{}"})
     */
    private $overrides = [];

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
}
