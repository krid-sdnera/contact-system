<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Exception;
use Doctrine\ORM\EntityManagerInterface;
use OpenAPI\Server\Model\ScoutGroupData;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScoutGroupRepository")
 */
class ScoutGroup
{
    private static $entityManager;

    public static function setEntityManager(EntityManagerInterface $entityManager)
    {
        self::$entityManager = $entityManager;
    }

    public static function fromExtranetRole(ExtranetRole $extranetRole)
    {

        if (empty(self::$entityManager)) {
            throw new Exception('Missing entity manager in scout group entity');
        }

        /** @var ScoutGroupRepository */
        $scoutGroupRepo = self::$entityManager->getRepository(self::class);

        echo "Processing ScoutGroup {$extranetRole->getExternalId()}: Checking by externalId" . PHP_EOL;
        // Look for for scout group by external id
        /** @var ScoutGroup */
        $scoutGroup = $scoutGroupRepo->findOneBy([
            'externalId' => $extranetRole->getGroupId()
        ]);

        if (!$scoutGroup) {
            echo "Processing ScoutGroup {$extranetRole->getExternalId()}: Not found by externalId, creating" . PHP_EOL;
            // Still no scout group matched. Let's create one.
            $scoutGroup = new self();
            $scoutGroup->setName($extranetRole->getGroupName());
            $scoutGroup->setExternalId($extranetRole->getGroupId());
        }

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
