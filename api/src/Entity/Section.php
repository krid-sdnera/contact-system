<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Exception;
use Doctrine\ORM\EntityManagerInterface;
use OpenAPI\Server\Model\SectionData;
use Psr\Log\LoggerInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SectionRepository")
 */
class Section
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
            throw new Exception('Missing entity manager or logger in section entity');
        }

        $logPrefix = "[section extranet={$extranetRole->getExternalId()}]";

        /** @var SectionRepository */
        $sectionRepo = self::$entityManager->getRepository(self::class);

        self::$logger->info("{$logPrefix} Checking by externalId");
        // Look for for section by external id
        /** @var Section */
        $section = $sectionRepo->findOneBy([
            'externalId' => $extranetRole->getSectionId()
        ]);

        if (!$section) {
            $sectionToString = "[section name={$extranetRole->getSectionName()} classId={$extranetRole->getNormalisedClassId()}]";
            self::$logger->notice("{$logPrefix} Not found by externalId, creating {$sectionToString}");
            // Still no section matched. Let's create one.
            $section = new self();
            $section->setName($extranetRole->getSectionName());
            $section->setExternalId($extranetRole->getSectionId());

            $section->setScoutGroup(ScoutGroup::fromExtranetRole($extranetRole));
        }

        $_loggableId = $section->getId() ? $section->getId() : 'known after creation';
        self::$logger->debug("{$logPrefix} Entity loaded at id: {$_loggableId}");

        return $section;
    }

    public function toSectionData(): SectionData
    {
        $arrayData = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'externalId' => $this->getExternalId(),
            'scoutGroup' => $this->getScoutGroup()->toScoutGroupData(),
        ];

        $data = new SectionData($arrayData);

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
     * @ORM\ManyToOne(targetEntity="App\Entity\ScoutGroup", cascade={"persist"}, inversedBy="sections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $scoutGroup;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $externalId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Role", mappedBy="section")
     */
    private $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
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

    public function getScoutGroup(): ?ScoutGroup
    {
        return $this->scoutGroup;
    }

    public function setScoutGroup(?ScoutGroup $scoutGroup): self
    {
        $this->scoutGroup = $scoutGroup;

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
     * @return Collection|Role[]
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
            $role->setSection($this);
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
            // set the owning side to null (unless already changed)
            if ($role->getSection() === $this) {
                $role->setSection(null);
            }
        }

        return $this;
    }
}
