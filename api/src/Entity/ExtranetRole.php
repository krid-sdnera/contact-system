<?php

namespace App\Entity;

class ExtranetRole
{
    private $roleName;
    private $roleId;
    private $classId;
    private $normalisedClassId;
    private $sectionName;
    private $sectionId;
    private $groupName;
    private $groupId;
    private $externalId;

    public function __construct(
        $roleName,
        $roleId,
        $classId,
        $normalisedClassId,
        $sectionName,
        $sectionId,
        $groupName,
        $groupId
    ) {
        $this->roleName = $roleName;
        $this->roleId = $roleId;
        $this->classId = $classId;
        $this->normalisedClassId = $normalisedClassId;
        $this->sectionName = $sectionName;
        $this->sectionId = $sectionId;
        $this->groupName = $groupName;
        $this->groupId = $groupId;
        $this->externalId = $roleId . '-' . $sectionId . '-' . $groupId;
    }

    public function getRoleName(): string
    {
        return $this->roleName;
    }

    public function setRoleName($roleName): self
    {
        $this->roleName = $roleName;

        return $this;
    }

    public function getRoleId(): string
    {
        return $this->roleId;
    }

    public function setRoleId(int $roleId): self
    {
        $this->roleId = $roleId;

        return $this;
    }

    public function getClassId(): string
    {
        return $this->classId;
    }

    public function setClassId(int $classId): self
    {
        $this->classId = $classId;

        return $this;
    }

    public function getNormalisedClassId(): string
    {
        return $this->normalisedClassId;
    }


    public function setNormalisedClassId(int $normalisedClassId): self
    {
        $this->normalisedClassId = $normalisedClassId;

        return $this;
    }

    public function getSectionName(): string
    {
        return $this->sectionName;
    }

    public function setSectionName(string $sectionName): self
    {
        $this->sectionName = $sectionName;

        return $this;
    }

    public function getSectionId(): string
    {
        return $this->sectionId;
    }

    public function setSectionId(int $sectionId): self
    {
        $this->sectionId = $sectionId;

        return $this;
    }

    public function getGroupName(): string
    {
        return $this->groupName;
    }

    public function setGroupName(string $groupName): self
    {
        $this->groupName = $groupName;

        return $this;
    }

    public function getGroupId(): string
    {
        return $this->groupId;
    }

    public function setGroupId($groupId): self
    {
        $this->groupId = $groupId;

        return $this;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function setExternalId($externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }
}
