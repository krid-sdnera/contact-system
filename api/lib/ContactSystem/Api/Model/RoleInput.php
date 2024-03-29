<?php
/**
 * RoleInput
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
 * Class representing the RoleInput model.
 *
 * @package OpenAPI\Server\Model
 * @author  OpenAPI Generator team
 */
class RoleInput 
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
     * @SerializedName("classId")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $classId;

    /**
     * @var string|null
     * @SerializedName("normalisedClassId")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $normalisedClassId;

    /**
     * @var string|null
     * @SerializedName("externalId")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $externalId;

    /**
     * @var int
     * @SerializedName("sectionId")
     * @Assert\NotNull()
     * @Assert\Type("int")
     * @Type("int")
     */
    protected $sectionId;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->name = isset($data['name']) ? $data['name'] : null;
        $this->classId = isset($data['classId']) ? $data['classId'] : null;
        $this->normalisedClassId = isset($data['normalisedClassId']) ? $data['normalisedClassId'] : null;
        $this->externalId = isset($data['externalId']) ? $data['externalId'] : null;
        $this->sectionId = isset($data['sectionId']) ? $data['sectionId'] : null;
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
     * Gets classId.
     *
     * @return string|null
     */
    public function getClassId(): ?string
    {
        return $this->classId;
    }

    /**
     * Sets classId.
     *
     * @param string|null $classId
     *
     * @return $this
     */
    public function setClassId(string $classId = null)
    {
        $this->classId = $classId;

        return $this;
    }

    /**
     * Gets normalisedClassId.
     *
     * @return string|null
     */
    public function getNormalisedClassId(): ?string
    {
        return $this->normalisedClassId;
    }

    /**
     * Sets normalisedClassId.
     *
     * @param string|null $normalisedClassId
     *
     * @return $this
     */
    public function setNormalisedClassId(string $normalisedClassId = null)
    {
        $this->normalisedClassId = $normalisedClassId;

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
     * Gets sectionId.
     *
     * @return int
     */
    public function getSectionId(): int
    {
        return $this->sectionId;
    }

    /**
     * Sets sectionId.
     *
     * @param int $sectionId
     *
     * @return $this
     */
    public function setSectionId(int $sectionId)
    {
        $this->sectionId = $sectionId;

        return $this;
    }
}


