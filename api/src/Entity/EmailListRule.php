<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use OpenAPI\Server\Model\ListRuleData;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmailListRuleRepository")
 */
class EmailListRule
{
    public function toListRuleData(): ListRuleData
    {

        if ($this->getMember()) {
            $relationType = 'Member';
            $relationName = $this->getMember()->getFirstname() . ' ' . $this->getMember()->getLastname();
            $relationId = $this->getMember()->getId();
        } else if ($this->getContact()) {
            $relationType = 'Contact';
            $relationName = $this->getContact()->getFirstname() . ' ' . $this->getContact()->getLastname();
            $relationId = $this->getContact()->getId();
        } else if ($this->getRole()) {
            $relationType = 'Role';
            $relationName = $this->getRole()->getName();
            $relationId = $this->getRole()->getId();
        } else if ($this->getSection()) {
            $relationType = 'Section';
            $relationName = $this->getSection()->getName();
            $relationId = $this->getSection()->getId();
        } else if ($this->getScoutGroup()) {
            $relationType = 'ScoutGroup';
            $relationName = $this->getScoutGroup()->getName();
            $relationId = $this->getScoutGroup()->getId();
        } else {
            $relationType = 'None';
            $relationName = 'None';
            $relationId = -1;
        }


        $arrayData = [
            'id' => $this->getId(),
            'label' => $this->getLabel(),
            'comment' => $this->getComment(),
            'listId' => $this->getEmailList()->getId(),
            'listName' => $this->getEmailList()->getName(),
            'listAddress' => $this->getEmailList()->getAddress(),
            'relationType' => $relationType,
            'relationName' => $relationName,
            'relationId' => $relationId,
            'useMember' => $this->getUseMember(),
            'useContact' => $this->getUseContact(),
        ];

        $data = new ListRuleData($arrayData);

        return $data;
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contact")
     */
    private $contact;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member")
     */
    private $member;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role")
     */
    private $role;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Section")
     */
    private $section;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ScoutGroup")
     */
    private $scoutGroup;

    /**
     * @ORM\Column(type="boolean")
     */
    private $useMember;

    /**
     * @ORM\Column(type="boolean")
     */
    private $useContact;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EmailList", inversedBy="rules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $emailList;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $comment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
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

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

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

    public function getUseMember(): ?bool
    {
        return $this->useMember;
    }

    public function setUseMember(bool $useMember): self
    {
        $this->useMember = $useMember;

        return $this;
    }

    public function getUseContact(): ?bool
    {
        return $this->useContact;
    }

    public function setUseContact(bool $useContact): self
    {
        $this->useContact = $useContact;

        return $this;
    }

    public function getEmailList(): ?EmailList
    {
        return $this->emailList;
    }

    public function setEmailList(?EmailList $emailList): self
    {
        $this->emailList = $emailList;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
