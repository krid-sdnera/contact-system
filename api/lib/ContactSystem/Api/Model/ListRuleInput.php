<?php
/**
 * ListRuleInput
 *
 * PHP version 5
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
 * Class representing the ListRuleInput model.
 *
 * @package OpenAPI\Server\Model
 * @author  OpenAPI Generator team
 */
class ListRuleInput 
{
        /**
     * @var string
     * @SerializedName("label")
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $label;

    /**
     * @var string
     * @SerializedName("comment")
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $comment;

    /**
     * @var int|null
     * @SerializedName("contactId")
     * @Assert\Type("int")
     * @Type("int")
     */
    protected $contactId;

    /**
     * @var int|null
     * @SerializedName("memberId")
     * @Assert\Type("int")
     * @Type("int")
     */
    protected $memberId;

    /**
     * @var int|null
     * @SerializedName("roleId")
     * @Assert\Type("int")
     * @Type("int")
     */
    protected $roleId;

    /**
     * @var int|null
     * @SerializedName("sectionId")
     * @Assert\Type("int")
     * @Type("int")
     */
    protected $sectionId;

    /**
     * @var int|null
     * @SerializedName("scoutGroupId")
     * @Assert\Type("int")
     * @Type("int")
     */
    protected $scoutGroupId;

    /**
     * @var bool
     * @SerializedName("useMember")
     * @Assert\NotNull()
     * @Assert\Type("bool")
     * @Type("bool")
     */
    protected $useMember;

    /**
     * @var bool
     * @SerializedName("useContact")
     * @Assert\NotNull()
     * @Assert\Type("bool")
     * @Type("bool")
     */
    protected $useContact;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->label = isset($data['label']) ? $data['label'] : null;
        $this->comment = isset($data['comment']) ? $data['comment'] : null;
        $this->contactId = isset($data['contactId']) ? $data['contactId'] : null;
        $this->memberId = isset($data['memberId']) ? $data['memberId'] : null;
        $this->roleId = isset($data['roleId']) ? $data['roleId'] : null;
        $this->sectionId = isset($data['sectionId']) ? $data['sectionId'] : null;
        $this->scoutGroupId = isset($data['scoutGroupId']) ? $data['scoutGroupId'] : null;
        $this->useMember = isset($data['useMember']) ? $data['useMember'] : null;
        $this->useContact = isset($data['useContact']) ? $data['useContact'] : null;
    }

    /**
     * Gets label.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Sets label.
     *
     * @param string $label
     *
     * @return $this
     */
    public function setLabel(string $label): string
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Gets comment.
     *
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * Sets comment.
     *
     * @param string $comment
     *
     * @return $this
     */
    public function setComment(string $comment): string
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Gets contactId.
     *
     * @return int|null
     */
    public function getContactId(): ?int
    {
        return $this->contactId;
    }

    /**
     * Sets contactId.
     *
     * @param int|null $contactId
     *
     * @return $this
     */
    public function setContactId(int $contactId = null): ?int
    {
        $this->contactId = $contactId;

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
    public function setMemberId(int $memberId = null): ?int
    {
        $this->memberId = $memberId;

        return $this;
    }

    /**
     * Gets roleId.
     *
     * @return int|null
     */
    public function getRoleId(): ?int
    {
        return $this->roleId;
    }

    /**
     * Sets roleId.
     *
     * @param int|null $roleId
     *
     * @return $this
     */
    public function setRoleId(int $roleId = null): ?int
    {
        $this->roleId = $roleId;

        return $this;
    }

    /**
     * Gets sectionId.
     *
     * @return int|null
     */
    public function getSectionId(): ?int
    {
        return $this->sectionId;
    }

    /**
     * Sets sectionId.
     *
     * @param int|null $sectionId
     *
     * @return $this
     */
    public function setSectionId(int $sectionId = null): ?int
    {
        $this->sectionId = $sectionId;

        return $this;
    }

    /**
     * Gets scoutGroupId.
     *
     * @return int|null
     */
    public function getScoutGroupId(): ?int
    {
        return $this->scoutGroupId;
    }

    /**
     * Sets scoutGroupId.
     *
     * @param int|null $scoutGroupId
     *
     * @return $this
     */
    public function setScoutGroupId(int $scoutGroupId = null): ?int
    {
        $this->scoutGroupId = $scoutGroupId;

        return $this;
    }

    /**
     * Gets useMember.
     *
     * @return bool
     */
    public function isUseMember(): bool
    {
        return $this->useMember;
    }

    /**
     * Sets useMember.
     *
     * @param bool $useMember
     *
     * @return $this
     */
    public function setUseMember(bool $useMember): bool
    {
        $this->useMember = $useMember;

        return $this;
    }

    /**
     * Gets useContact.
     *
     * @return bool
     */
    public function isUseContact(): bool
    {
        return $this->useContact;
    }

    /**
     * Sets useContact.
     *
     * @param bool $useContact
     *
     * @return $this
     */
    public function setUseContact(bool $useContact): bool
    {
        $this->useContact = $useContact;

        return $this;
    }
}


