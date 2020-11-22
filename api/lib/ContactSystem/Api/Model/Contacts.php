<?php
/**
 * Contacts
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
 * Class representing the Contacts model.
 *
 * A list of contacts
 *
 * @package OpenAPI\Server\Model
 * @author  OpenAPI Generator team
 */
class Contacts 
{
        /**
     * Array containg the list
     *
     * @var OpenAPI\Server\Model\ContactData[]
     * @SerializedName("contacts")
     * @Assert\NotNull()
     * @Assert\All({
     *   @Assert\Type("OpenAPI\Server\Model\ContactData")
     * })
     * @Type("array<OpenAPI\Server\Model\ContactData>")
     */
    protected $contacts;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->contacts = isset($data['contacts']) ? $data['contacts'] : null;
    }

    /**
     * Gets contacts.
     *
     * @return OpenAPI\Server\Model\ContactData[]
     */
    public function getContacts(): array
    {
        return $this->contacts;
    }

    /**
     * Sets contacts.
     *
     * @param OpenAPI\Server\Model\ContactData[] $contacts  Array containg the list
     *
     * @return $this
     */
    public function setContacts(array $contacts): array
    {
        $this->contacts = $contacts;

        return $this;
    }
}

