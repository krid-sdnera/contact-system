<?php
/**
 * ContactResponse
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
 * Class representing the ContactResponse model.
 *
 * @package OpenAPI\Server\Model
 * @author  OpenAPI Generator team
 */
class ContactResponse 
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
     * @var OpenAPI\Server\Model\ContactData
     * @SerializedName("contact")
     * @Assert\NotNull()
     * @Assert\Valid()
     * @Assert\Type("OpenAPI\Server\Model\ContactData")
     * @Type("OpenAPI\Server\Model\ContactData")
     */
    protected $contact;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->success = isset($data['success']) ? $data['success'] : null;
        $this->contact = isset($data['contact']) ? $data['contact'] : null;
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
     * Gets contact.
     *
     * @return OpenAPI\Server\Model\ContactData
     */
    public function getContact(): ContactData
    {
        return $this->contact;
    }

    /**
     * Sets contact.
     *
     * @param OpenAPI\Server\Model\ContactData $contact
     *
     * @return $this
     */
    public function setContact(ContactData $contact)
    {
        $this->contact = $contact;

        return $this;
    }
}


