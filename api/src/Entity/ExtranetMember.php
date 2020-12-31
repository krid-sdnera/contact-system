<?php

namespace App\Entity;

class ExtranetMember
{
    private $membershipNumber;

    // Section & group
    private $sectionId;
    private $sectionName;
    private $groupId;
    private $groupName;
    private $classId;

    private $firstname;
    private $nickname;
    private $lastname;
    private $dateOfBirth;
    private $gender;

    private $homeAddress;
    private $homeSuburb;
    private $homeState;
    private $homePostcode;
    private $homePhone;
    private $workPhone;
    private $mobile;
    private $email;

    private $schoolName;
    private $schoolYearLevel;

    private $membershipUpdateLink;

    private $contacts = [];
    private $role;
    private $subsidiarySections = [];
    private $position;

    public function __construct()
    {
    }

    public function getMembershipNumber(): string
    {
        return $this->membershipNumber;
    }

    public function setMembershipNumber($membershipNumber): self
    {
        $this->membershipNumber = $membershipNumber;

        return $this;
    }

    // Section & group

    public function getSectionId(): string
    {
        return $this->sectionId;
    }

    public function setSectionId($sectionId): self
    {
        $this->sectionId = $sectionId;

        return $this;
    }

    public function getSectionName(): string
    {
        return $this->sectionName;
    }

    public function setSectionName($sectionName): self
    {
        $this->sectionName = $sectionName;

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

    public function getGroupName(): string
    {
        return $this->groupName;
    }

    public function setGroupName($groupName): self
    {
        $this->groupName = $groupName;

        return $this;
    }

    public function getClassId(): string
    {
        return $this->classId;
    }

    public function setClassId($classId): self
    {
        $this->classId = $classId;

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

    public function getDateOfBirth(): string
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(string $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

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

    // School details
    public function getSchoolName(): string
    {
        return $this->schoolName;
    }

    public function setSchoolName($schoolName): self
    {
        $this->schoolName = $schoolName;

        return $this;
    }

    public function getSchoolYearLevel(): string
    {
        return $this->schoolYearLevel || '';
    }

    public function setSchoolYearLevel($yearLevel): self
    {
        $this->schoolYearLevel = $yearLevel;

        return $this;
    }

    // Other

    public function getMembershipUpdateLink(): string
    {
        return ($this->membershipUpdateLink) ?: '';
    }

    public function setMembershipUpdateLink($membershipUpdateLink): self
    {
        $this->membershipUpdateLink = $membershipUpdateLink;

        return $this;
    }


    public function getRole(): string
    {
        return ($this->role) ?: '';
    }

    public function setRole($role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getPosition(): string
    {
        return ($this->position) ?: '';
    }

    public function setPosition($position): self
    {
        $this->position = $position;

        return $this;
    }

    // Relationships

    public function getSubsidiarySections(): array
    {
        return $this->subsidiarySections;
    }

    public function addSubsidiarySection($subsidiarySection): self
    {
        $this->subsidiarySections[] = $subsidiarySection;

        return $this;
    }

    public function setMemberUpdateLink($memberUpdateLink): self
    {
        $this->memberUpdateLink = $memberUpdateLink;

        return $this;
    }

    public function getContacts(): array
    {
        return $this->contacts;
    }

    public function addContact($contact): self
    {
        $this->contacts[] = $contact;

        return $this;
    }

    // Data mappers

    public static function fromExtranetCsv($data)
    {
        $member = new self();

        $member->setMembershipNumber($data['RegID']);
        $member->setSectionId($data['SectionID']);
        $member->setSectionName($data['SectionName']);
        $member->setGroupId($data['GroupID']);
        $member->setGroupName($data['GroupName']);
        $member->setClassId($data['ClassID']);
        $member->setFirstname($data['Firstname']);
        $member->setNickname($data['Preferedname']);
        $member->setLastname($data['Surname']);
        $member->setDateOfBirth($data['DOB']);
        // $member->setGender($data['Gender']);
        $member->setHomeAddress($data['HomeAddress']);
        $member->setHomeSuburb($data['HomeSuburb']);
        $member->setHomeState($data['HomeState']);
        $member->setHomePostcode($data['HomePostcode']);
        $member->setHomePhone($data['Homephone']);
        $member->setWorkPhone($data['Workphone']);
        $member->setMobile($data['Mobile']);
        $member->setEmail($data['Email']);
        $member->setSchoolName($data['SchoolName']);
        // $member->setSchoolYearLevel($data['SchoolYearLevel']);
        // $member->setMembershipUpdateLink($data['MembershipUpdateLink']);
        if (isset($data['Role'])) {
            $member->setRole($data['Role']);
        }
        if (isset($data['Position'])) {
            $member->setPosition($data['Position']);
        }
        // $member->addSubsidiarySection($data['SubsidiarySection']);
        // $member->addContact($data['Contact']);

        // var_dump($member);
        // var_dump($data['RegID']);
        // echo json_encode($member->toArray(), JSON_PRETTY_PRINT);


        return $member;
    }

    public static function fromExtranetInvitation($data)
    {
        $member = new self();

        $member->setMembershipNumber($data['id']);

        $member->setSectionId($data['sectionID']);
        $member->setSectionName($data['formation']);
        $member->setGroupId(substr($data['formationID'], 0, 7));
        $member->setGroupName(substr($data['formation'], 0, strrpos($data['formation'], '-')));
        $member->setClassId($data['classID']);
        $member->setFirstname($data['firstname']);
        $member->setLastname($data['surname']);

        if (isset($data['dob'])) {
            $member->setDateOfBirth($data['dob']);
        } else {
            $member->setDateOfBirth('');
        }

        if (isset($data['email'])) {
            $member->setEmail($data['email']);
        } else {
            $member->setEmail('');
        }

        if (isset($data['role'])) {
            $member->setRole($data['role']);
        }

        $member->setNickname('');
        $member->setGender('');
        $member->setHomeAddress('');
        $member->setHomeSuburb('');
        $member->setHomeState('');
        $member->setHomePostcode('');
        $member->setHomePhone('');
        $member->setWorkPhone('');
        $member->setMobile('');
        $member->setEmail('');
        $member->setSchoolName('');
        $member->setPosition('');


        return $member;
    }

    public static function fromArray($data)
    {
        $member = new self();

        $member->setMembershipNumber($data['membershipNumber']);
        $member->setSectionId($data['sectionId']);
        $member->setSectionName($data['sectionName']);
        $member->setGroupId($data['groupId']);
        $member->setGroupName($data['groupName']);
        $member->setClassId($data['classId']);
        $member->setFirstname($data['firstname']);
        $member->setNickname($data['nickname']);
        $member->setLastname($data['lastname']);
        $member->setDateOfBirth($data['dateOfBirth']);
        $member->setGender($data['gender']);
        $member->setHomeAddress($data['homeAddress']);
        $member->setHomeSuburb($data['homeSuburb']);
        $member->setHomeState($data['homeState']);
        $member->setHomePostcode($data['homePostcode']);
        $member->setHomePhone($data['homePhone']);
        $member->setWorkPhone($data['workPhone']);
        $member->setMobile($data['mobile']);
        $member->setEmail($data['email']);
        $member->setSchoolName($data['schoolName']);
        $member->setSchoolYearLevel($data['schoolYearLevel']);
        $member->setMembershipUpdateLink($data['membershipUpdateLink']);
        $member->setRole($data['role']);
        $member->setPosition($data['position']);

        foreach ($data['subsidiarySections'] as $i => $section) {
            $member->addSubsidiarySection($section);
        }
        foreach ($data['contacts'] as $i => $contact) {
            $member->addContact(ExtranetContact::fromArray($contact));
        }

        return $member;
    }

    public function toArray()
    {
        $arrayData = [
            'membershipNumber' => $this->getMembershipNumber(),
            'sectionId' => $this->getSectionId(),
            'sectionName' => $this->getSectionName(),
            'groupId' => $this->getGroupId(),
            'groupName' => $this->getGroupName(),
            'classId' => $this->getClassId(),
            'firstname' => $this->getFirstname(),
            'nickname' => $this->getNickname(),
            'lastname' => $this->getLastname(),
            'dateOfBirth' => $this->getDateOfBirth(),
            'gender' => $this->getGender(),
            'homeAddress' => $this->getHomeAddress(),
            'homeSuburb' => $this->getHomeSuburb(),
            'homeState' => $this->getHomeState(),
            'homePostcode' => $this->getHomePostcode(),
            'homePhone' => $this->getHomePhone(),
            'workPhone' => $this->getWorkPhone(),
            'mobile' => $this->getMobile(),
            'email' => $this->getEmail(),
            'schoolName' => $this->getSchoolName(),
            'schoolYearLevel' => $this->getSchoolYearLevel(),
            'membershipUpdateLink' => $this->getMembershipUpdateLink(),
            'role' => $this->getRole(),
            'position' => $this->getPosition(),
            'subsidiarySections' => $this->subsidiarySections,
            'contacts' => array_map(
                function ($contact) {
                    return $contact->toArray();
                },
                $this->contacts
            )
        ];
        return $arrayData;
    }
}
