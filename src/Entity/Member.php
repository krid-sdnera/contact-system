<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use DateTime;

use Exception;
use Doctrine\ORM\EntityManagerInterface;

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

    public static function generateRole($roleName, $sectionName, $groupName, $externalId, $type)
    {
        return [
            'name' => $roleName,
            'section' => $sectionName,
            'group' => $groupName,
            'externalId' => $externalId,
            'type' =>  $type
        ];
    }


    public static function fromExtranetMember(ExtranetMember $extranetMember)
    {

        if (empty(self::$entityManager)) {
            throw new Exception('Missing entity manager in member entity');
        }

        $memberRepo = self::$entityManager->getRepository(self::class);

        // Look for for member by membershipNumber
        /** @var Member */
        $member = $memberRepo->findOneBy([
            'membershipNumber' => $extranetMember->getMembershipNumber()
        ]);

        if (!$member) {
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
                ->getResult();
        }

        if (!$member) {
            // Still no member matched. Let's create one.
            $member = new self();
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

        /**
         * Roles
         */
        // Build expected roles.
        $roles = [];

        $youthRoles = [
            'JOEY',
            'CUB',
            'SCOUT',
            'VENT',
            'ROVER'
        ];

        if (in_array($extranetMember->getClassId(), $youthRoles)) {
            $roles[] = self::generateRole(
                'Youth',
                $extranetMember->getSectionName(),
                $extranetMember->getGroupName(),
                'Youth' .
                    $extranetMember->getSectionId() .
                    $extranetMember->getGroupId(),

                'classIdYouth'
            );
        } elseif ($extranetMember->getClassId() === 'LDR') {
            preg_match(
                '/(?:A-Z\s)?(JOEY SCOUT|CUB SCOUT|SCOUT|VENTURER|ROVER|GROUP)\s+(?:LDR|LEADER)/',
                $extranetMember->getRole(),
                $matches
            );

            if (count($matches) == 2) {
                $section = $matches[1];
                //Remove {CUB}" SCOUT" & {JOEY}" SCOUT"
                $section = preg_replace('/(.+?)(?: SCOUT)?/', '$1', $section);
                //Remove {VENT}"URER"
                $section = preg_replace('/(.+?)(?:URER)?/',   '$1', $section);
            } else {
                $section = 'GROUP';
            }

            $list = array(
                'JOEY'  => 'M1',
                'CUB'   => 'P1',
                'SCOUT' => 'T1',
                'VENT'  => 'U1',
                'ROVER' => 'C1',
                'GROUP' => ''
            );

            $roles[] = self::generateRole(
                $extranetMember->getRole(),
                $extranetMember->getSectionName() . " - " . $section,
                $extranetMember->getGroupName(),
                $extranetMember->getRole() .
                    $extranetMember->getSectionId() . $list[$section] .
                    $extranetMember->getGroupId(),
                'classIdLeader'
            );
        } elseif ($extranetMember->getClassId() === 'OB') {
            // Convert Position to Roles
            $positions = $extranetMember->getPosition();

            if ($positions) {
                $positionArray = preg_split('/,\s*/', $positions);

                foreach ($positionArray as $i => $position) {
                    $roles[] = self::generateRole(
                        $position,
                        'Group',
                        $extranetMember->getGroupName(),
                        $position,
                        'classIdOffice'
                    );
                }
            }
        } elseif ($extranetMember->getClassId() === 'AH') {
            $roles[] = self::generateRole(
                'Adult Helper',
                $extranetMember->getSectionName(),
                $extranetMember->getGroupName(),
                'Adult Helper' .
                    $extranetMember->getSectionId() .
                    $extranetMember->getGroupId(),
                'classIdAdultHelper'
            );
        }

        // Convert Subsidiary Sections to Roles
        $subSections = $extranetMember->getSubsidiarySections();
        foreach ($subSections as $i => $section) {
            $roles[] = [
                'name' => 'youth member',
                'section' => $section['SectionName'],
                'group' => 'TODO: Derive from SectionName',
                'externalId' => $section['SectionID'],
                'type' => 'subsidiarySection'
            ];
        }

        // Compare current roles
        $extranetRolesConsidered = [];
        foreach ($member->getRoles() as $i => $role) {
            $key = array_search($role->getExternalId(), array_column($roles, 'externalId'));

            // Is this role also in extranet?
            if ($key !== false) {
                // Yes this role is in extranet
                $member->getRoles()[$i]->setManagementState(self::ManagementStateManaged);
                $member->getRoles()[$i]->setExpiry(null);

                $extranetRolesConsidered[] = $roles[$key]['externalId'];
            } else {
                // No this role is not in extranet
                $member->getRoles()[$i]->setManagementState(self::UnmanagementStateManaged);
                $member->getRoles()[$i]->setExpiry(new DateTime());
            }
        }

        foreach ($roles as $i => $role) {
            // Is this role assigned to the member?
            if (in_array($role['externalId'], $extranetRolesConsidered)) {
                // Yes this role is assigned to the member
            } else {
                // No this role is not assigned to the member

                // Look up this externalId

                // else
                // $newRole = new Role();
                // $newRole->setName()
                // $member->addRole($newRole);
            }
        }

        /**
         * Contacts
         */
        // Compare current contacts
        $extranetContactsConsidered = [];
        foreach ($member->getContacts() as $i => $contact) {
            $key = array_search($contact->getParentId(), array_column($extranetMember->getContacts(), 'parentId'));

            // Is this contact also in extranet?
            if ($key !== false) {
                // Yes this contact is in extranet
                $member->getContacts()[$i]->setManagementState(self::ManagementStateManaged);
                $member->getContacts()[$i]->setExpiry(null);

                $extranetContactsConsidered[] = $extranetMember->getContacts()[$key]['parentId'];
            } else {
                // No this contact is not in extranet
                $member->getContacts()[$i]->setManagementState(self::UnmanagementStateManaged);
                $member->getContacts()[$i]->setExpiry(new DateTime());
            }
        }

        foreach ($extranetMember->getContacts() as $i => $contact) {
            // Is this contact assigned to the member?
            // TODO make ParentID into parentId
            if (in_array($contact->getParentId(), $extranetContactsConsidered)) {
                // Yes this contact is assigned to the member
            } else {
                // No this contact is not assigned to the member

                // Look up this parentId

                // else
                // $newContact = new Contact();
                // $newContact->setName()
                // $member->addContact($newContact);


                $member->addContact(Contact::fromExtranetContact($contact));
            }
        }

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
     * @ORM\OneToMany(targetEntity="App\Entity\MemberRole", mappedBy="member")
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contact", mappedBy="member")
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
