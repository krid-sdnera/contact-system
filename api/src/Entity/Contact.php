<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use OpenAPI\Server\Model\AddressData;
use OpenAPI\Server\Model\ContactData;
use OpenAPI\Server\Model\ContactOverrideData;
use Psr\Log\LoggerInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
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

    public static function fromExtranetContact(ExtranetContact $extranetContact)
    {
        if (empty(self::$entityManager) || empty(self::$logger)) {
            throw new Exception('Missing entity manager or logger in contact entity');
        }

        $logPrefix = "[contact extranet={$extranetContact->getParentId()}]";

        /** @var ContactRepository */
        $contactRepo = self::$entityManager->getRepository(self::class);

        self::$logger->info("{$logPrefix} Checking by parentId");
        // Look for for contact by parentId
        /** @var Contact */
        $contact = $contactRepo->findOneBy([
            'parentId' => $extranetContact->getParentId()
        ]);

        if (!$contact) {
            self::$logger->info("{$logPrefix} Not found by parentId, checking by name");
            // Attempt to match up with an existing record
            $contact = $contactRepo->createQueryBuilder('m')
                ->where("m.firstname LIKE :firstname")
                ->andWhere("m.lastname LIKE :lastname")
                ->andWhere("m.relationship = :relationship")
                ->andWhere("m.managementState = :state")
                ->setParameter("firstname", '%' . addcslashes($extranetContact->getFirstname(), '%_') . '%')
                ->setParameter("lastname", '%' . addcslashes($extranetContact->getLastname(), '%_') . '%')
                ->setParameter("relationship", $extranetContact->getRelationship())
                ->setParameter("state", 'unmanaged')
                ->getQuery()
                ->getOneOrNullResult();
        }

        if (!$contact) {
            $contactToString = "[contact firstname={$extranetContact->getFirstname()} lastname={$extranetContact->getLastname()}]";
            self::$logger->notice("{$logPrefix} Not found by name, creating {$contactToString}");
            // Still no contact matched. Let's create one.
            $contact = new self();
            $contact->setState(self::DefaultState);
        }

        $_loggableId = $contact->getId() ? $contact->getId() : 'known after creation';
        self::$logger->debug("{$logPrefix} Entity loaded at id: {$_loggableId}");

        // Update name fields
        if ($contact->overridable('firstname')) {
            $contact->setFirstname($extranetContact->getFirstname());
        }
        if ($contact->overridable('nickname')) {
            $contact->setNickname($extranetContact->getNickname());
        }
        if ($contact->overridable('lastname')) {
            $contact->setLastname($extranetContact->getLastname());
        }
        if ($contact->overridable('primaryContact')) {
            $contact->setPrimaryContact($extranetContact->getPrimaryContact());
        }
        if ($contact->overridable('occupation')) {
            $contact->setOccupation($extranetContact->getOccupation());
        }
        if ($contact->overridable('relationship')) {
            $contact->setRelationship($extranetContact->getRelationship());
        }

        // Update address        
        if ($contact->overridable('address')) {
            $contact->setAddress(array(
                'street1' => $extranetContact->getHomeAddress(),
                'street2' => '',
                'city' => $extranetContact->getHomeSuburb(),
                'state' => $extranetContact->getHomeState(),
                'postcode' => $extranetContact->getHomePostcode(),
            ));
        }

        // Update contact details
        if ($contact->overridable('phoneHome')) {
            $contact->setPhoneHome($extranetContact->getHomephone());
        }
        if ($contact->overridable('phoneWork')) {
            $contact->setPhoneWork($extranetContact->getWorkPhone());
        }
        if ($contact->overridable('phoneMobile')) {
            $contact->setPhoneMobile($extranetContact->getMobile());
        }
        if ($contact->overridable('email')) {
            $contact->setEmail($extranetContact->getEmail());
        }

        // Always do these fields.
        $contact->setParentId($extranetContact->getParentId());
        $contact->setManagementState(self::ManagementStateManaged);
        $contact->setExpiry(null);
        // Do not update `state`.

        return $contact;
    }

    public function overridable(string $overrideKey)
    {
        $overrides = $this->getOverrides();

        // Check to see if there is an override defined for this field.
        $hasOverride = (isset($overrides[$overrideKey]) && $overrides[$overrideKey] === true);

        // If there is an override set up. Then this field can not be overriden.
        return !$hasOverride;
    }

    public function toContactData(): ContactData
    {
        $arrayData = [
            'id' => $this->getId(),
            'state' => $this->getState(),
            'managementState' => $this->getManagementState(),
            'expiry' => ($this->getExpiry()) ? $this->getExpiry()->format(DateTimeInterface::ISO8601) : null,
            'memberId' => $this->getMember()->getId(),
            'firstname' => $this->getFirstname(),
            'nickname' => $this->getNickname(),
            'lastname' => $this->getLastname(),
            'occupation' => $this->getOccupation(),
            'relationship' => $this->getRelationship(),
            'parentId' => $this->getParentId(),
            'address' => new AddressData($this->getAddress()),
            'phoneHome' => $this->getPhoneHome(),
            'phoneWork' => $this->getPhoneWork(),
            'phoneMobile' => $this->getPhoneMobile(),
            'email' => $this->getEmail(),
            'primaryContact' => $this->getPrimaryContact(),
            'overrides' => new ContactOverrideData($this->getOverrides()),
        ];

        $data = new ContactData($arrayData);

        return $data;
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $parentId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nickname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

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
    private $occupation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="contacts", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $member;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $relationship;

    /**
     * @ORM\Column(type="boolean")
     */
    private $primaryContact;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function setParentId(?int $parentId): self
    {
        $this->parentId = $parentId;

        return $this;
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

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(?string $nickname): self
    {
        $this->nickname = $nickname;

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

    public function getAddress(): ?array
    {
        return $this->address;
    }

    public function setAddress(array $address): self
    {
        $this->address = $address;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getOccupation(): ?string
    {
        return $this->occupation;
    }

    public function setOccupation(?string $occupation): self
    {
        $this->occupation = $occupation;

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        $this->member = $member;

        return $this;
    }

    public function getRelationship(): ?string
    {
        return $this->relationship;
    }

    public function setRelationship(?string $relationship): self
    {
        $this->relationship = $relationship;

        return $this;
    }

    public function getPrimaryContact(): ?bool
    {
        return $this->primaryContact;
    }

    public function setPrimaryContact(bool $primaryContact): self
    {
        $this->primaryContact = $primaryContact;

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
}
