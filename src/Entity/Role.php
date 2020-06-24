<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Exception;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 */
class Role
{

    private static $entityManager;

    public static function setEntityManager(EntityManagerInterface $entityManager)
    {
        self::$entityManager = $entityManager;
    }

    public static function fromExtranetRole(ExtranetRole $extranetRole)
    {

        if (empty(self::$entityManager)) {
            throw new Exception('Missing entity manager in role entity');
        }

        /** @var RoleRepository */
        $roleRepo = self::$entityManager->getRepository(self::class);

        // Look for for role by external id
        /** @var Role */
        $role = $roleRepo->findOneBy([
            'externalId' => $extranetRole->getExternalId()
        ]);

        if (!$role) {
            // No role matched. Let's create one.
            $role = new self();
            $role->setName($extranetRole->getRoleName());
            $role->setClassId($extranetRole->getClassId());
            $role->setNormalisedClassId($extranetRole->getNormalisedClassId());
            $role->setExternalId($extranetRole->getRoleId());

            $role->setSection(Section::fromExtranetRole($extranetRole));
        }

        return $role;
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Section", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
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
}
