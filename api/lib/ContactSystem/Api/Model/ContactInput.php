<?php
/**
 * ContactInput
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
 * Class representing the ContactInput model.
 *
 * @package OpenAPI\Server\Model
 * @author  OpenAPI Generator team
 */
class ContactInput 
{
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
     * @SerializedName("firstname")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $firstname;

    /**
     * @var string|null
     * @SerializedName("nickname")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $nickname;

    /**
     * @var string|null
     * @SerializedName("lastname")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $lastname;

    /**
     * @var OpenAPI\Server\Model\AddressData|null
     * @SerializedName("address")
     * @Assert\Type("OpenAPI\Server\Model\AddressData")
     * @Type("OpenAPI\Server\Model\AddressData")
     */
    protected $address;

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
     * @SerializedName("relationship")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $relationship;

    /**
     * @var bool|null
     * @SerializedName("primaryContact")
     * @Assert\Type("bool")
     * @Type("bool")
     */
    protected $primaryContact;

    /**
     * @var string|null
     * @SerializedName("email")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $email;

    /**
     * @var string|null
     * @SerializedName("occupation")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $occupation;

    /**
     * @var int|null
     * @SerializedName("memberId")
     * @Assert\Type("int")
     * @Type("int")
     */
    protected $memberId;

    /**
     * @var int|null
     * @SerializedName("parentId")
     * @Assert\Type("int")
     * @Type("int")
     */
    protected $parentId;

    /**
     * @var string|null
     * @SerializedName("expiry")
     * @Assert\Type("string")
     * @Type("string")
     * @Assert\Regex("/^\\d{4}-\\d{2}-\\d{2}$/")
     */
    protected $expiry;

    /**
     * @var OpenAPI\Server\Model\ContactOverrideData|null
     * @SerializedName("overrides")
     * @Assert\Type("OpenAPI\Server\Model\ContactOverrideData")
     * @Type("OpenAPI\Server\Model\ContactOverrideData")
     */
    protected $overrides;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->state = isset($data['state']) ? $data['state'] : null;
        $this->firstname = isset($data['firstname']) ? $data['firstname'] : null;
        $this->nickname = isset($data['nickname']) ? $data['nickname'] : null;
        $this->lastname = isset($data['lastname']) ? $data['lastname'] : null;
        $this->address = isset($data['address']) ? $data['address'] : null;
        $this->phoneHome = isset($data['phoneHome']) ? $data['phoneHome'] : null;
        $this->phoneMobile = isset($data['phoneMobile']) ? $data['phoneMobile'] : null;
        $this->phoneWork = isset($data['phoneWork']) ? $data['phoneWork'] : null;
        $this->relationship = isset($data['relationship']) ? $data['relationship'] : null;
        $this->primaryContact = isset($data['primaryContact']) ? $data['primaryContact'] : null;
        $this->email = isset($data['email']) ? $data['email'] : null;
        $this->occupation = isset($data['occupation']) ? $data['occupation'] : null;
        $this->memberId = isset($data['memberId']) ? $data['memberId'] : null;
        $this->parentId = isset($data['parentId']) ? $data['parentId'] : null;
        $this->expiry = isset($data['expiry']) ? $data['expiry'] : null;
        $this->overrides = isset($data['overrides']) ? $data['overrides'] : null;
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
     * Gets firstname.
     *
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * Sets firstname.
     *
     * @param string|null $firstname
     *
     * @return $this
     */
    public function setFirstname(string $firstname = null)
    {
        $this->firstname = $firstname;

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
     * Gets lastname.
     *
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * Sets lastname.
     *
     * @param string|null $lastname
     *
     * @return $this
     */
    public function setLastname(string $lastname = null)
    {
        $this->lastname = $lastname;

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
     * Gets relationship.
     *
     * @return string|null
     */
    public function getRelationship(): ?string
    {
        return $this->relationship;
    }

    /**
     * Sets relationship.
     *
     * @param string|null $relationship
     *
     * @return $this
     */
    public function setRelationship(string $relationship = null)
    {
        $this->relationship = $relationship;

        return $this;
    }

    /**
     * Gets primaryContact.
     *
     * @return bool|null
     */
    public function isPrimaryContact(): ?bool
    {
        return $this->primaryContact;
    }

    /**
     * Sets primaryContact.
     *
     * @param bool|null $primaryContact
     *
     * @return $this
     */
    public function setPrimaryContact(bool $primaryContact = null)
    {
        $this->primaryContact = $primaryContact;

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
     * Gets occupation.
     *
     * @return string|null
     */
    public function getOccupation(): ?string
    {
        return $this->occupation;
    }

    /**
     * Sets occupation.
     *
     * @param string|null $occupation
     *
     * @return $this
     */
    public function setOccupation(string $occupation = null)
    {
        $this->occupation = $occupation;

        return $this;
    }

    /**
     * Gets memberId.
     *
     * @return int|null
     */
    public function getMemberId(): ?int
    {
        return $this->memberId;
    }

    /**
     * Sets memberId.
     *
     * @param int|null $memberId
     *
     * @return $this
     */
    public function setMemberId(int $memberId = null)
    {
        $this->memberId = $memberId;

        return $this;
    }

    /**
     * Gets parentId.
     *
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    /**
     * Sets parentId.
     *
     * @param int|null $parentId
     *
     * @return $this
     */
    public function setParentId(int $parentId = null)
    {
        $this->parentId = $parentId;

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
     * @return OpenAPI\Server\Model\ContactOverrideData|null
     */
    public function getOverrides(): ?ContactOverrideData
    {
        return $this->overrides;
    }

    /**
     * Sets overrides.
     *
     * @param OpenAPI\Server\Model\ContactOverrideData|null $overrides
     *
     * @return $this
     */
    public function setOverrides(ContactOverrideData $overrides = null)
    {
        $this->overrides = $overrides;

        return $this;
    }
}


