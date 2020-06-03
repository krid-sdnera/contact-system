<?php

namespace App\Entity;

class ExtranetMember
{
    public function __construct($member)
    {
        foreach ($member as $key => $value) {
            $this->$key = $value;
        }
    }

    public function setMembershipNumber($membershipNumber)
    {
        $this->membershipNumber = $membershipNumber;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function setYearLevel($yearLevel)
    {
        $this->yearLevel = $yearLevel;
    }

    public function addSubsidiarySection($subsidiarySection)
    {
        $this->subsidiarySections[] = $subsidiarySection;
    }

    public function setMemberUpdateLink($memberUpdateLink)
    {
        $this->memberUpdateLink = $memberUpdateLink;
    }

    public function addContact($contact)
    {
        $this->contacts[] = $contact;
    }
}
