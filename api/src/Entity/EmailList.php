<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use OpenAPI\Server\Model\ListData;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmailListRepository")
 */
class EmailList
{

    public function toListData(): ListData
    {
        $arrayData = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'address' => $this->getAddress()
        ];

        $data = new ListData($arrayData);

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
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EmailListRule", mappedBy="emailList", orphanRemoval=true)
     */
    private $rules;

    public function __construct()
    {
        $this->rules = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection|EmailListRule[]
     */
    public function getEmailListRules(): Collection
    {
        return $this->rules;
    }

    public function addEmailListRule(EmailListRule $rule): self
    {
        if (!$this->rules->contains($rule)) {
            $this->rules[] = $rule;
            $rule->setEmailList($this);
        }

        return $this;
    }

    public function removeEmailListRule(EmailListRule $rule): self
    {
        if ($this->rules->contains($rule)) {
            $this->rules->removeElement($rule);
            // set the owning side to null (unless already changed)
            if ($rule->getEmailList() === $this) {
                $rule->setEmailList(null);
            }
        }

        return $this;
    }
}
