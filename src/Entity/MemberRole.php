<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberRoleRepository")
 */
class MemberRole
{

    const DefaultManagementState = 'unmanaged';
    const DefaultState = 'enabled';
    const DefaultOverrides = [];

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

    public function getId(): ?int
    {
        return $this->id;
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
