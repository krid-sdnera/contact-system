<?php
/**
 * RoleData
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
 * Class representing the RoleData model.
 *
 * @package OpenAPI\Server\Model
 * @author  OpenAPI Generator team
 */
class RoleData 
{
        /**
     * @var string
     * @SerializedName("id")
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $id;

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
     * @var OpenAPI\Server\Model\SectionData
     * @SerializedName("section")
     * @Assert\NotNull()
     * @Assert\Type("OpenAPI\Server\Model\SectionData")
     * @Type("OpenAPI\Server\Model\SectionData")
     */
    protected $section;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->id = isset($data['id']) ? $data['id'] : null;
        $this->name = isset($data['name']) ? $data['name'] : null;
        $this->externalId = isset($data['externalId']) ? $data['externalId'] : null;
        $this->section = isset($data['section']) ? $data['section'] : null;
    }

    /**
     * Gets id.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Sets id.
     *
     * @param string $id
     *
     * @return $this
     */
    public function setId(string $id): string
    {
        $this->id = $id;

        return $this;
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
    public function setName(string $name): string
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
    public function setExternalId(string $externalId = null): ?string
    {
        $this->externalId = $externalId;

        return $this;
    }

    /**
     * Gets section.
     *
     * @return OpenAPI\Server\Model\SectionData
     */
    public function getSection(): SectionData
    {
        return $this->section;
    }

    /**
     * Sets section.
     *
     * @param OpenAPI\Server\Model\SectionData $section
     *
     * @return $this
     */
    public function setSection(SectionData $section): SectionData
    {
        $this->section = $section;

        return $this;
    }
}


