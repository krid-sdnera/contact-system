<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Exception;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberRoleRepository")
 */
class MemberRole
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

    public static function fromExtranetRole(Member $member, ExtranetRole $extranetRole)
    {

        if (empty(self::$entityManager)) {
            throw new Exception('Missing entity manager in member role entity');
        }

        /** @var MemberRoleRepository */
        $memberRoleRepo = self::$entityManager->getRepository(self::class);

        // Get new or existing role.
        $role = Role::fromExtranetRole($extranetRole);

        // Lets check for a relationship entity
        /** @var MemberRole */
        $relatioshipEntity = $memberRoleRepo->findOneBy([
            'member' => $member->getId(),
            'role' => $role->getId()
        ]);

        if (!$relatioshipEntity) {
            // We can create one
            $relatioshipEntity = new self();
            $relatioshipEntity->setMember($member);
            $relatioshipEntity->setRole($role);
            $relatioshipEntity->setState(self::DefaultState);
        }

        $relatioshipEntity->setManagementState(self::ManagementStateManaged);
        $relatioshipEntity->setExpiry(null);

        self::$entityManager->persist($role);

        return $relatioshipEntity;
    }

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Member")
     */
    private $member;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Role")
     */
    private $role;

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

    public function getId(): ?string
    {
        return $this->member->getId() . $this->role->getId();
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

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

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
}
