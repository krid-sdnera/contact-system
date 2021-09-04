<?php
/**
 * MemberRoleInput
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
 * Class representing the MemberRoleInput model.
 *
 * @package OpenAPI\Server\Model
 * @author  OpenAPI Generator team
 */
class MemberRoleInput 
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
     * @SerializedName("expiry")
     * @Assert\Type("string")
     * @Type("string")
     * @Assert\Regex("/^\d{4}-\d{2}-\d{2}$/")
     */
    protected $expiry;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->state = isset($data['state']) ? $data['state'] : null;
        $this->expiry = isset($data['expiry']) ? $data['expiry'] : null;
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
}


