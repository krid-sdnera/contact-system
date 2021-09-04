<?php
/**
 * SectionInput
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
 * Class representing the SectionInput model.
 *
 * @package OpenAPI\Server\Model
 * @author  OpenAPI Generator team
 */
class SectionInput 
{
        /**
     * @var string
     * @SerializedName("name")
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $name;

    /**
     * @var string|null
     * @SerializedName("externalId")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $externalId;

    /**
     * @var int
     * @SerializedName("scoutGroupId")
     * @Assert\NotNull()
     * @Assert\Type("int")
     * @Type("int")
     */
    protected $scoutGroupId;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->name = isset($data['name']) ? $data['name'] : null;
        $this->externalId = isset($data['externalId']) ? $data['externalId'] : null;
        $this->scoutGroupId = isset($data['scoutGroupId']) ? $data['scoutGroupId'] : null;
    }

    /**
     * Gets name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets name.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Gets externalId.
     *
     * @return string|null
     */
    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    /**
     * Sets externalId.
     *
     * @param string|null $externalId
     *
     * @return $this
     */
    public function setExternalId(string $externalId = null)
    {
        $this->externalId = $externalId;

        return $this;
    }

    /**
     * Gets scoutGroupId.
     *
     * @return int
     */
    public function getScoutGroupId(): int
    {
        return $this->scoutGroupId;
    }

    /**
     * Sets scoutGroupId.
     *
     * @param int $scoutGroupId
     *
     * @return $this
     */
    public function setScoutGroupId(int $scoutGroupId)
    {
        $this->scoutGroupId = $scoutGroupId;

        return $this;
    }
}


