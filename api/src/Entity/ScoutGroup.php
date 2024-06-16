<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Exception;
use Doctrine\ORM\EntityManagerInterface;
use OpenAPI\Server\Model\ScoutGroupData;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScoutGroupRepository")
 */
class ScoutGroup
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
            throw new Exception('Missing entity manager or logger in scout group entity');
        }

        $logPrefix = "[scout-group extranet={$extranetRole->getExternalId()}]";

        /** @var ScoutGroupRepository */
        $scoutGroupRepo = self::$entityManager->getRepository(self::class);

        self::$logger->info("{$logPrefix} Checking by externalId");
        // Look for for scout group by external id
        /** @var ScoutGroup */
        $scoutGroup = $scoutGroupRepo->findOneBy([
            'externalId' => $extranetRole->getGroupId()
        ]);

        if (!$scoutGroup) {
            $groupToString = "[group name={$extranetRole->getGroupName()} classId={$extranetRole->getNormalisedClassId()}]";
            self::$logger->notice("{$logPrefix} Not found by externalId, creating {$groupToString}");
            // Still no scout group matched. Let's create one.
            $scoutGroup = new self();
            $scoutGroup->setName($extranetRole->getGroupName());
            $scoutGroup->setExternalId($extranetRole->getGroupId());
        }

        $_loggableId = $scoutGroup->getId() ? $scoutGroup->getId() : 'known after creation';
        self::$logger->debug("{$logPrefix} Entity loaded at id: {$_loggableId}");

        return $scoutGroup;
    }

    public function toScoutGroupData(): ScoutGroupData
    {
        $arrayData = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'externalId' => $this->getExternalId(),
        ];

        $data = new ScoutGroupData($arrayData);

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
     * @ORM\Column(type="string", length=255)
     */
    private $externalId;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Section", mappedBy="scoutGroup")
     * @MaxDepth(1)
     */
    private $sections;


    public function __construct()
    {
        $this->sections = new ArrayCollection();
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
     * @return Collection|Section[]
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(Section $section): self
    {
        if (!$this->sections->contains($section)) {
            $this->sections[] = $section;
            $section->setScoutGroup($this);
        }

        return $this;
    }

    public function removeSection(Section $section): self
    {
        if ($this->sections->contains($section)) {
            $this->sections->removeElement($section);
            // set the owning side to null (unless already changed)
            if ($section->getScoutGroup() === $this) {
                $section->setScoutGroup(null);
            }
        }

        return $this;
    }
}
