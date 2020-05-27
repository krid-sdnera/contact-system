<?php
/**
 * AddressData
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
 * Class representing the AddressData model.
 *
 * @package OpenAPI\Server\Model
 * @author  OpenAPI Generator team
 */
class AddressData 
{
        /**
     * @var string|null
     * @SerializedName("street1")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $street1;

    /**
     * @var string|null
     * @SerializedName("street2")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $street2;

    /**
     * @var string|null
     * @SerializedName("city")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $city;

    /**
     * @var string|null
     * @SerializedName("state")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $state;

    /**
     * @var int|null
     * @SerializedName("postcode")
     * @Assert\Type("int")
     * @Type("int")
     */
    protected $postcode;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->street1 = isset($data['street1']) ? $data['street1'] : null;
        $this->street2 = isset($data['street2']) ? $data['street2'] : null;
        $this->city = isset($data['city']) ? $data['city'] : null;
        $this->state = isset($data['state']) ? $data['state'] : null;
        $this->postcode = isset($data['postcode']) ? $data['postcode'] : null;
    }

    /**
     * Gets street1.
     *
     * @return string|null
     */
    public function getStreet1()
    {
        return $this->street1;
    }

    /**
     * Sets street1.
     *
     * @param string|null $street1
     *
     * @return $this
     */
    public function setStreet1($street1 = null)
    {
        $this->street1 = $street1;

        return $this;
    }

    /**
     * Gets street2.
     *
     * @return string|null
     */
    public function getStreet2()
    {
        return $this->street2;
    }

    /**
     * Sets street2.
     *
     * @param string|null $street2
     *
     * @return $this
     */
    public function setStreet2($street2 = null)
    {
        $this->street2 = $street2;

        return $this;
    }

    /**
     * Gets city.
     *
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets city.
     *
     * @param string|null $city
     *
     * @return $this
     */
    public function setCity($city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Gets state.
     *
     * @return string|null
     */
    public function getState()
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
    public function setState($state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Gets postcode.
     *
     * @return int|null
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Sets postcode.
     *
     * @param int|null $postcode
     *
     * @return $this
     */
    public function setPostcode($postcode = null)
    {
        $this->postcode = $postcode;

        return $this;
    }
}


