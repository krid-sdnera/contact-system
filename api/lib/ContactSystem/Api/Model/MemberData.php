<?php
/**
 * MemberData
 *
 * PHP version 7.1.3
 *
 * @category Class
 * @package  OpenAPI\Server\Model
 * @author   OpenAPI Generator team
 * @link     https://github.com/openapitools/openapi-generator
 */

/**
 * Contact System API
 *
 * This is the spec for the Constact system API
 *
 * The version of the OpenAPI document: 1.0.0
 * Contact: dirk@arends.com.au
 * Generated by: https://github.com/openapitools/openapi-generator.git
 *
 */

/**
 * NOTE: This class is auto generated by the openapi generator program.
 * https://github.com/openapitools/openapi-generator
 * Do not edit the class manually.
 */

namespace OpenAPI\Server\Model;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;

/**
 * Class representing the MemberData model.
 *
 * @package OpenAPI\Server\Model
 * @author  OpenAPI Generator team
 */
class MemberData 
{
        /**
     * @var int
     * @SerializedName("id")
     * @Assert\NotNull()
     * @Assert\Type("int")
     * @Type("int")
     */
    protected $id;

    /**
     * @var string|null
     * @SerializedName("state")
     * @Assert\Choice({ "enabled", "disabled" })
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $state;

    /**
     * @var string|null
     * @SerializedName("managementState")
     * @Assert\Choice({ "managed", "unmanaged" })
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $managementState;

    /**
     * @var string
     * @SerializedName("firstname")
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $firstname;

    /**
     * @var string
     * @SerializedName("lastname")
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $lastname;

    /**
     * @var string|null
     * @SerializedName("nickname")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $nickname;

    /**
     * @var OpenAPI\Server\Model\AddressData|null
     * @SerializedName("address")
     * @Assert\Type("OpenAPI\Server\Model\AddressData")
     * @Type("OpenAPI\Server\Model\AddressData")
     */
    protected $address;

    /**
     * @var \DateTime|null
     * @SerializedName("dateOfBirth")
     * @Assert\Date()
     * @Type("DateTime")
     */
    protected $dateOfBirth;

    /**
     * @var string|null
     * @SerializedName("membershipNumber")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $membershipNumber;

    /**
     * @var string|null
     * @SerializedName("membershipUpdateLink")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $membershipUpdateLink;

    /**
     * @var bool|null
     * @SerializedName("autoUpgradeEnabled")
     * @Assert\Type("bool")
     * @Type("bool")
     */
    protected $autoUpgradeEnabled;

    /**
     * @var string|null
     * @SerializedName("email")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $email;

    /**
     * @var string|null
     * @SerializedName("phoneHome")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $phoneHome;

    /**
     * @var string|null
     * @SerializedName("phoneMobile")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $phoneMobile;

    /**
     * @var string|null
     * @SerializedName("phoneWork")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $phoneWork;

    /**
     * @var string|null
     * @SerializedName("gender")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $gender;

    /**
     * @var string|null
     * @SerializedName("schoolName")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $schoolName;

    /**
     * @var string|null
     * @SerializedName("schoolYearLevel")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $schoolYearLevel;

    /**
     * @var string|null
     * @SerializedName("expiry")
     * @Assert\Type("string")
     * @Type("string")
     * @Assert\Regex("/^\d{4}-\d{2}-\d{2}$/")
     */
    protected $expiry;

    /**
     * @var OpenAPI\Server\Model\MemberOverrideData|null
     * @SerializedName("overrides")
     * @Assert\Type("OpenAPI\Server\Model\MemberOverrideData")
     * @Type("OpenAPI\Server\Model\MemberOverrideData")
     */
    protected $overrides;

    /**
     * @var OpenAPI\Server\Model\MemberMetaInviteData|null
     * @SerializedName("metaInvite")
     * @Assert\Type("OpenAPI\Server\Model\MemberMetaInviteData")
     * @Type("OpenAPI\Server\Model\MemberMetaInviteData")
     */
    protected $metaInvite;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->id = isset($data['id']) ? $data['id'] : null;
        $this->state = isset($data['state']) ? $data['state'] : null;
        $this->managementState = isset($data['managementState']) ? $data['managementState'] : null;
        $this->firstname = isset($data['firstname']) ? $data['firstname'] : null;
        $this->lastname = isset($data['lastname']) ? $data['lastname'] : null;
        $this->nickname = isset($data['nickname']) ? $data['nickname'] : null;
        $this->address = isset($data['address']) ? $data['address'] : null;
        $this->dateOfBirth = isset($data['dateOfBirth']) ? $data['dateOfBirth'] : null;
        $this->membershipNumber = isset($data['membershipNumber']) ? $data['membershipNumber'] : null;
        $this->membershipUpdateLink = isset($data['membershipUpdateLink']) ? $data['membershipUpdateLink'] : null;
        $this->autoUpgradeEnabled = isset($data['autoUpgradeEnabled']) ? $data['autoUpgradeEnabled'] : null;
        $this->email = isset($data['email']) ? $data['email'] : null;
        $this->phoneHome = isset($data['phoneHome']) ? $data['phoneHome'] : null;
        $this->phoneMobile = isset($data['phoneMobile']) ? $data['phoneMobile'] : null;
        $this->phoneWork = isset($data['phoneWork']) ? $data['phoneWork'] : null;
        $this->gender = isset($data['gender']) ? $data['gender'] : null;
        $this->schoolName = isset($data['schoolName']) ? $data['schoolName'] : null;
        $this->schoolYearLevel = isset($data['schoolYearLevel']) ? $data['schoolYearLevel'] : null;
        $this->expiry = isset($data['expiry']) ? $data['expiry'] : null;
        $this->overrides = isset($data['overrides']) ? $data['overrides'] : null;
        $this->metaInvite = isset($data['metaInvite']) ? $data['metaInvite'] : null;
    }

    /**
     * Gets id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Sets id.
     *
     * @param int $id
     *
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets state.
     *
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->state;
    }

    /**
     * Sets state.
     *
     * @param string|null $state
     *
     * @return $this
     */
    public function setState(string $state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Gets managementState.
     *
     * @return string|null
     */
    public function getManagementState(): ?string
    {
        return $this->managementState;
    }

    /**
     * Sets managementState.
     *
     * @param string|null $managementState
     *
     * @return $this
     */
    public function setManagementState(string $managementState = null)
    {
        $this->managementState = $managementState;

        return $this;
    }

    /**
     * Gets firstname.
     *
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * Sets firstname.
     *
     * @param string $firstname
     *
     * @return $this
     */
    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Gets lastname.
     *
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * Sets lastname.
     *
     * @param string $lastname
     *
     * @return $this
     */
    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Gets nickname.
     *
     * @return string|null
     */
    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    /**
     * Sets nickname.
     *
     * @param string|null $nickname
     *
     * @return $this
     */
    public function setNickname(string $nickname = null)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Gets address.
     *
     * @return OpenAPI\Server\Model\AddressData|null
     */
    public function getAddress(): ?AddressData
    {
        return $this->address;
    }

    /**
     * Sets address.
     *
     * @param OpenAPI\Server\Model\AddressData|null $address
     *
     * @return $this
     */
    public function setAddress(AddressData $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Gets dateOfBirth.
     *
     * @return \DateTime|null
     */
    public function getDateOfBirth(): ?\DateTime
    {
        return $this->dateOfBirth;
    }

    /**
     * Sets dateOfBirth.
     *
     * @param \DateTime|null $dateOfBirth
     *
     * @return $this
     */
    public function setDateOfBirth(\DateTime $dateOfBirth = null)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Gets membershipNumber.
     *
     * @return string|null
     */
    public function getMembershipNumber(): ?string
    {
        return $this->membershipNumber;
    }

    /**
     * Sets membershipNumber.
     *
     * @param string|null $membershipNumber
     *
     * @return $this
     */
    public function setMembershipNumber(string $membershipNumber = null)
    {
        $this->membershipNumber = $membershipNumber;

        return $this;
    }

    /**
     * Gets membershipUpdateLink.
     *
     * @return string|null
     */
    public function getMembershipUpdateLink(): ?string
    {
        return $this->membershipUpdateLink;
    }

    /**
     * Sets membershipUpdateLink.
     *
     * @param string|null $membershipUpdateLink
     *
     * @return $this
     */
    public function setMembershipUpdateLink(string $membershipUpdateLink = null)
    {
        $this->membershipUpdateLink = $membershipUpdateLink;

        return $this;
    }

    /**
     * Gets autoUpgradeEnabled.
     *
     * @return bool|null
     */
    public function isAutoUpgradeEnabled(): ?bool
    {
        return $this->autoUpgradeEnabled;
    }

    /**
     * Sets autoUpgradeEnabled.
     *
     * @param bool|null $autoUpgradeEnabled
     *
     * @return $this
     */
    public function setAutoUpgradeEnabled(bool $autoUpgradeEnabled = null)
    {
        $this->autoUpgradeEnabled = $autoUpgradeEnabled;

        return $this;
    }

    /**
     * Gets email.
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Sets email.
     *
     * @param string|null $email
     *
     * @return $this
     */
    public function setEmail(string $email = null)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Gets phoneHome.
     *
     * @return string|null
     */
    public function getPhoneHome(): ?string
    {
        return $this->phoneHome;
    }

    /**
     * Sets phoneHome.
     *
     * @param string|null $phoneHome
     *
     * @return $this
     */
    public function setPhoneHome(string $phoneHome = null)
    {
        $this->phoneHome = $phoneHome;

        return $this;
    }

    /**
     * Gets phoneMobile.
     *
     * @return string|null
     */
    public function getPhoneMobile(): ?string
    {
        return $this->phoneMobile;
    }

    /**
     * Sets phoneMobile.
     *
     * @param string|null $phoneMobile
     *
     * @return $this
     */
    public function setPhoneMobile(string $phoneMobile = null)
    {
        $this->phoneMobile = $phoneMobile;

        return $this;
    }

    /**
     * Gets phoneWork.
     *
     * @return string|null
     */
    public function getPhoneWork(): ?string
    {
        return $this->phoneWork;
    }

    /**
     * Sets phoneWork.
     *
     * @param string|null $phoneWork
     *
     * @return $this
     */
    public function setPhoneWork(string $phoneWork = null)
    {
        $this->phoneWork = $phoneWork;

        return $this;
    }

    /**
     * Gets gender.
     *
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * Sets gender.
     *
     * @param string|null $gender
     *
     * @return $this
     */
    public function setGender(string $gender = null)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Gets schoolName.
     *
     * @return string|null
     */
    public function getSchoolName(): ?string
    {
        return $this->schoolName;
    }

    /**
     * Sets schoolName.
     *
     * @param string|null $schoolName
     *
     * @return $this
     */
    public function setSchoolName(string $schoolName = null)
    {
        $this->schoolName = $schoolName;

        return $this;
    }

    /**
     * Gets schoolYearLevel.
     *
     * @return string|null
     */
    public function getSchoolYearLevel(): ?string
    {
        return $this->schoolYearLevel;
    }

    /**
     * Sets schoolYearLevel.
     *
     * @param string|null $schoolYearLevel
     *
     * @return $this
     */
    public function setSchoolYearLevel(string $schoolYearLevel = null)
    {
        $this->schoolYearLevel = $schoolYearLevel;

        return $this;
    }

    /**
     * Gets expiry.
     *
     * @return string|null
     */
    public function getExpiry(): ?string
    {
        return $this->expiry;
    }

    /**
     * Sets expiry.
     *
     * @param string|null $expiry
     *
     * @return $this
     */
    public function setExpiry(string $expiry = null)
    {
        $this->expiry = $expiry;

        return $this;
    }

    /**
     * Gets overrides.
     *
     * @return OpenAPI\Server\Model\MemberOverrideData|null
     */
    public function getOverrides(): ?MemberOverrideData
    {
        return $this->overrides;
    }

    /**
     * Sets overrides.
     *
     * @param OpenAPI\Server\Model\MemberOverrideData|null $overrides
     *
     * @return $this
     */
    public function setOverrides(MemberOverrideData $overrides = null)
    {
        $this->overrides = $overrides;

        return $this;
    }

    /**
     * Gets metaInvite.
     *
     * @return OpenAPI\Server\Model\MemberMetaInviteData|null
     */
    public function getMetaInvite(): ?MemberMetaInviteData
    {
        return $this->metaInvite;
    }

    /**
     * Sets metaInvite.
     *
     * @param OpenAPI\Server\Model\MemberMetaInviteData|null $metaInvite
     *
     * @return $this
     */
    public function setMetaInvite(MemberMetaInviteData $metaInvite = null)
    {
        $this->metaInvite = $metaInvite;

        return $this;
    }
}


