<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Exception;
use Doctrine\ORM\EntityManagerInterface;
use OpenAPI\Server\Model\RoleData;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Serializer\Annotation\Ignore;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 */
class Role
{

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

    public static function fromExtranetRole(ExtranetRole $extranetRole)
    {
        if (empty(self::$entityManager) || empty(self::$logger)) {
            throw new Exception('Missing entity manager or logger in role entity');
        }

        $logPrefix = "[role extranet={$extranetRole->getExternalId()}]";

        /** @var RoleRepository */
        $roleRepo = self::$entityManager->getRepository(self::class);

        self::$logger->info("{$logPrefix} Checking by externalId");
        // Look for for role by external id
        /** @var Role */
        $role = $roleRepo->findOneBy([
            'externalId' => $extranetRole->getExternalId()
        ]);

        if (!$role) {
            $roleToString = "[role name={$extranetRole->getRoleName()} classId={$extranetRole->getNormalisedClassId()}]";
            self::$logger->notice("{$logPrefix} Not found by externalId, creating {$roleToString}");
            // No role matched. Let's create one.
            $role = new self();
            $role->setName($extranetRole->getRoleName());
            $role->setClassId($extranetRole->getClassId());
            $role->setNormalisedClassId($extranetRole->getNormalisedClassId());
            $role->setExternalId($extranetRole->getExternalId());

            $role->setSection(Section::fromExtranetRole($extranetRole));
        }

        $_loggableId = $role->getId() ? $role->getId() : 'known after creation';
        self::$logger->debug("{$logPrefix} Entity loaded at id: {$_loggableId}");

        return $role;
    }

    public function toRoleData(): RoleData
    {
        $arrayData = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'classId' => $this->getClassId(),
            'normalisedClassId' => $this->getNormalisedClassId(),
            'externalId' => $this->getExternalId(),
            'section' => $this->getSection()->toSectionData(),
        ];

        $data = new RoleData($arrayData);

        return $data;
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Section", cascade={"persist"}, inversedBy="roles")
     * @ORM\JoinColumn(nullable=false)
     * @MaxDepth(1)
     */
    private $section;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $classId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $normalisedClassId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $externalId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MemberRole", mappedBy="role")
     * @MaxDepth(1)
     * @Ignore()
     */
    private $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

        return $this;
    }

    public function getClassId(): ?string
    {
        return $this->classId;
    }

    public function setClassId(string $classId): self
    {
        $this->classId = $classId;

        return $this;
    }

    public function getNormalisedClassId(): ?string
    {
        return $this->normalisedClassId;
    }

    public function setNormalisedClassId(string $normalisedClassId): self
    {
        $this->normalisedClassId = $normalisedClassId;

        return $this;
    }

    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }

    /**
     * @return Collection|MemberRole[]
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(MemberRole $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->setRole($this);
        }

        return $this;
    }

    public function removeMember(MemberRole $member): self
    {
        if ($this->members->contains($member)) {
            $this->members->removeElement($member);
            // set the owning side to null (unless already changed)
            if ($member->getRole() === $this) {
                $member->setRole(null);
            }
        }

        return $this;
    }
}
