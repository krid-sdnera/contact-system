<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Exception;
use Doctrine\ORM\EntityManagerInterface;
use OpenAPI\Server\Model\SectionData;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SectionRepository")
 */
class Section
{

    private static $entityManager;

    public static function setEntityManager(EntityManagerInterface $entityManager)
    {
        self::$entityManager = $entityManager;
    }

    public static function fromExtranetRole(ExtranetRole $extranetRole)
    {

        if (empty(self::$entityManager)) {
            throw new Exception('Missing entity manager in section entity');
        }

        /** @var SectionRepository */
        $sectionRepo = self::$entityManager->getRepository(self::class);

        echo "Processing Section {$extranetRole->getSectionId()}: Checking by externalId" . PHP_EOL;
        // Look for for section by external id
        /** @var Section */
        $section = $sectionRepo->findOneBy([
            'externalId' => $extranetRole->getSectionId()
        ]);

        if (!$section) {
            echo "Processing Section {$extranetRole->getExternalId()}: Not found by externalId, creating" . PHP_EOL;
            // Still no section matched. Let's create one.
            $section = new self();
            $section->setName($extranetRole->getSectionName());
            $section->setExternalId($extranetRole->getSectionId());

            $section->setScoutGroup(ScoutGroup::fromExtranetRole($extranetRole));
        }

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
     * @ORM\ManyToOne(targetEntity="App\Entity\ScoutGroup", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $scoutGroup;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $externalId;

    public function __construct()
    {
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
}
