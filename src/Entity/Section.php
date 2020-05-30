<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SectionRepository")
 */
class Section
{
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
     * @ORM\OneToMany(targetEntity="App\Entity\Role", mappedBy="section")
     */
    private $roles;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ScoutGroup", inversedBy="sections")
     * @ORM\JoinColumn(nullable=false)
     */
    private $scoutGroup;

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

    public function getScoutGroup(): ?ScoutGroup
    {
        return $this->scoutGroup;
    }

    public function setScoutGroup(?ScoutGroup $scoutGroup): self
    {
        $this->scoutGroup = $scoutGroup;

        return $this;
    }
}
