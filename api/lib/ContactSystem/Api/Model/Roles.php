<?php
/**
 * Roles
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
 * Class representing the Roles model.
 *
 * A list of roles
 *
 * @package OpenAPI\Server\Model
 * @author  OpenAPI Generator team
 */
class Roles 
{
        /**
     * Array containg the list
     *
     * @var OpenAPI\Server\Model\RoleData[]
     * @SerializedName("roles")
     * @Assert\NotNull()
     * @Assert\All({
     *   @Assert\Type("OpenAPI\Server\Model\RoleData")
     * })
     * @Type("array<OpenAPI\Server\Model\RoleData>")
     */
    protected $roles;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->roles = isset($data['roles']) ? $data['roles'] : null;
    }

    /**
     * Gets roles.
     *
     * @return OpenAPI\Server\Model\RoleData[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * Sets roles.
     *
     * @param OpenAPI\Server\Model\RoleData[] $roles  Array containg the list
     *
     * @return $this
     */
    public function setRoles(array $roles): array
    {
        $this->roles = $roles;

        return $this;
    }
}


