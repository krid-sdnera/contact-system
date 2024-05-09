<?php
/**
 * ListResponse
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
 * Class representing the ListResponse model.
 *
 * @package OpenAPI\Server\Model
 * @author  OpenAPI Generator team
 */
class ListResponse 
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
     * @var OpenAPI\Server\Model\ListData
     * @SerializedName("list")
     * @Assert\NotNull()
     * @Assert\Valid()
     * @Assert\Type("OpenAPI\Server\Model\ListData")
     * @Type("OpenAPI\Server\Model\ListData")
     */
    protected $list;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->success = isset($data['success']) ? $data['success'] : null;
        $this->list = isset($data['list']) ? $data['list'] : null;
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
     * Gets list.
     *
     * @return OpenAPI\Server\Model\ListData
     */
    public function getList(): ListData
    {
        return $this->list;
    }

    /**
     * Sets list.
     *
     * @param OpenAPI\Server\Model\ListData $list
     *
     * @return $this
     */
    public function setList(ListData $list)
    {
        $this->list = $list;

        return $this;
    }
}


