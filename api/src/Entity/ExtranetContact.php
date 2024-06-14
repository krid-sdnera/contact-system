<?php

namespace App\Entity;

class ExtranetContact
{
    private $parentId;

    public $firstname;
    public $nickname;
    public $lastname;

    public $primaryContact;
    public $occupation;
    public $relationship;

    public $phoneHome;
    public $phoneWork;
    public $mobile;
    public $email;

    public $homeAddress;
    public $homeSuburb;
    public $homeState;
    public $homePostcode;

    public function __construct()
    {
    }

    public function getParentId(): string
    {
        return $this->parentId;
    }

    public function setParentId($parentId): self
    {
        $this->parentId = $parentId;

        return $this;
    }

    // Personal details

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }


    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    // Other details

    public function getPrimaryContact(): bool
    {
        return $this->primaryContact;
    }

    public function setPrimaryContact(bool $primaryContact): self
    {
        $this->primaryContact = $primaryContact;

        return $this;
    }

    public function getOccupation(): string
    {
        return $this->occupation;
    }

    public function setOccupation(string $occupation): self
    {
        $this->occupation = $occupation;

        return $this;
    }

    public function getRelationship(): string
    {
        return $this->relationship;
    }

    public function setRelationship(string $relationship): self
    {
        $this->relationship = $relationship;

        return $this;
    }

    // Contact details

    public function getHomeAddress(): string
    {
        return $this->homeAddress;
    }

    public function setHomeAddress($homeAddress): self
    {
        $this->homeAddress = $homeAddress;

        return $this;
    }

    public function getHomeSuburb(): string
    {
        return $this->homeSuburb;
    }

    public function setHomeSuburb($homeSuburb): self
    {
        $this->homeSuburb = $homeSuburb;

        return $this;
    }

    public function getHomeState(): string
    {
        return $this->homeState;
    }

    public function setHomeState($homeState): self
    {
        $this->homeState = $homeState;

        return $this;
    }

    public function getHomePostcode(): string
    {
        return $this->homePostcode;
    }

    public function setHomePostcode($homePostcode): self
    {
        $this->homePostcode = $homePostcode;

        return $this;
    }

    public function getHomePhone(): string
    {
        return $this->homePhone;
    }

    public function setHomePhone($homePhone): self
    {
        $this->homePhone = $homePhone;

        return $this;
    }

    public function getWorkPhone(): string
    {
        return $this->workPhone;
    }

    public function setWorkPhone($workPhone): self
    {
        $this->workPhone = $workPhone;

        return $this;
    }

    public function getMobile(): string
    {
        return $this->mobile;
    }

    public function setMobile($mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    // Data mappers

    public static function fromExtranetCsv($data)
    {
        $contact = new self();

        $contact->setParentId($data['ParentID']);

        $contact->setFirstname($data['Firstname']);
        $contact->setNickname(($data['Preferedname']) ?: '');
        $contact->setLastname($data['Surname']);

        $contact->setPrimaryContact($data['PrimaryContact'] === 'Y');
        $contact->setOccupation(($data['Occupation']) ?: '');
        $contact->setRelationship($data['Relationship']);

        $contact->setHomeAddress($data['HomeAddress']);
        $contact->setHomeSuburb($data['HomeSuburb']);
        $contact->setHomeState($data['HomeState']);
        $contact->setHomePostcode($data['HomePostcode']);
        $contact->setHomePhone($data['HomePhone']);
        $contact->setWorkPhone($data['WorkPhone']);
        $contact->setMobile($data['Mobile']);
        $contact->setEmail($data['Email']);

        return $contact;
    }

    public static function fromArray($data)
    {
        $contact = new self();

        $contact->setParentId($data['parentId']);

        $contact->setFirstname($data['firstname']);
        $contact->setNickname($data['nickname']);
        $contact->setLastname($data['lastname']);

        $contact->setPrimaryContact($data['primaryContact']);
        $contact->setOccupation($data['occupation']);
        $contact->setRelationship($data['relationship']);

        $contact->setHomeAddress($data['homeAddress']);
        $contact->setHomeSuburb($data['homeSuburb']);
        $contact->setHomeState($data['homeState']);
        $contact->setHomePostcode($data['homePostcode']);
        $contact->setHomePhone($data['homePhone']);
        $contact->setWorkPhone($data['workPhone']);
        $contact->setMobile($data['mobile']);
        $contact->setEmail($data['email']);

        return $contact;
    }

    public function toArray()
    {
        $arrayData = [
            'parentId' => $this->getParentId(),
            'firstname' => $this->getFirstname(),
            'nickname' => $this->getNickname(),
            'lastname' => $this->getLastname(),
            'primaryContact' => $this->getPrimaryContact(),
            'occupation' => $this->getOccupation(),
            'relationship' => $this->getRelationship(),
            'homeAddress' => $this->getHomeAddress(),
            'homeSuburb' => $this->getHomeSuburb(),
            'homeState' => $this->getHomeState(),
            'homePostcode' => $this->getHomePostcode(),
            'homePhone' => $this->getHomePhone(),
            'workPhone' => $this->getWorkPhone(),
            'mobile' => $this->getMobile(),
            'email' => $this->getEmail()
        ];

        return $arrayData;
    }
}
