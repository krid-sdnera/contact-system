<?php
/**
 * MemberResponse
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
 * Class representing the MemberResponse model.
 *
 * @package OpenAPI\Server\Model
 * @author  OpenAPI Generator team
 */
class MemberResponse 
{
        /**
     * Whether the request was successful or not
     *
     * @var bool
     * @SerializedName("success")
     * @Assert\NotNull()
     * @Assert\Type("bool")
     * @Type("bool")
     */
    protected $success;

    /**
     * @var OpenAPI\Server\Model\MemberData
     * @SerializedName("member")
     * @Assert\NotNull()
     * @Assert\Valid()
     * @Assert\Type("OpenAPI\Server\Model\MemberData")
     * @Type("OpenAPI\Server\Model\MemberData")
     */
    protected $member;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->success = isset($data['success']) ? $data['success'] : null;
        $this->member = isset($data['member']) ? $data['member'] : null;
    }

    /**
     * Gets success.
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * Sets success.
     *
     * @param bool $success  Whether the request was successful or not
     *
     * @return $this
     */
    public function setSuccess(bool $success)
    {
        $this->success = $success;

        return $this;
    }

    /**
     * Gets member.
     *
     * @return OpenAPI\Server\Model\MemberData
     */
    public function getMember(): MemberData
    {
        return $this->member;
    }

    /**
     * Sets member.
     *
     * @param OpenAPI\Server\Model\MemberData $member
     *
     * @return $this
     */
    public function setMember(MemberData $member)
    {
        $this->member = $member;

        return $this;
    }
}


