<?php
/**
 * AuditData
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
 * Class representing the AuditData model.
 *
 * @package OpenAPI\Server\Model
 * @author  OpenAPI Generator team
 */
class AuditData 
{
        /**
     * @var int
     * @SerializedName("id")
     * @Assert\NotNull()
     * @Assert\Type("int")
     * @Type("int")
     */
    protected $id;

    /**
     * @var string
     * @SerializedName("entityType")
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $entityType;

    /**
     * @var string
     * @SerializedName("entityId")
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $entityId;

    /**
     * @var string
     * @SerializedName("createdAt")
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Type("string")
     * @Assert\Regex("/^\\d{4}-\\d{2}-\\d{2} \\d{2}:\\d{2}:\\d{2}$/")
     */
    protected $createdAt;

    /**
     * @var OpenAPI\Server\Model\UserData|null
     * @SerializedName("user")
     * @Assert\Type("OpenAPI\Server\Model\UserData")
     * @Type("OpenAPI\Server\Model\UserData")
     */
    protected $user;

    /**
     * @var string
     * @SerializedName("action")
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $action;

    /**
     * @var string|null
     * @SerializedName("requestRoute")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $requestRoute;

    /**
     * @var string|null
     * @SerializedName("ipAddress")
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $ipAddress;

    /**
     * @var string
     * @SerializedName("eventData")
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $eventData;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->id = isset($data['id']) ? $data['id'] : null;
        $this->entityType = isset($data['entityType']) ? $data['entityType'] : null;
        $this->entityId = isset($data['entityId']) ? $data['entityId'] : null;
        $this->createdAt = isset($data['createdAt']) ? $data['createdAt'] : null;
        $this->user = isset($data['user']) ? $data['user'] : null;
        $this->action = isset($data['action']) ? $data['action'] : null;
        $this->requestRoute = isset($data['requestRoute']) ? $data['requestRoute'] : null;
        $this->ipAddress = isset($data['ipAddress']) ? $data['ipAddress'] : null;
        $this->eventData = isset($data['eventData']) ? $data['eventData'] : null;
    }

    /**
     * Gets id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Sets id.
     *
     * @param int $id
     *
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets entityType.
     *
     * @return string
     */
    public function getEntityType(): string
    {
        return $this->entityType;
    }

    /**
     * Sets entityType.
     *
     * @param string $entityType
     *
     * @return $this
     */
    public function setEntityType(string $entityType)
    {
        $this->entityType = $entityType;

        return $this;
    }

    /**
     * Gets entityId.
     *
     * @return string
     */
    public function getEntityId(): string
    {
        return $this->entityId;
    }

    /**
     * Sets entityId.
     *
     * @param string $entityId
     *
     * @return $this
     */
    public function setEntityId(string $entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * Gets createdAt.
     *
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * Sets createdAt.
     *
     * @param string $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(string $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Gets user.
     *
     * @return OpenAPI\Server\Model\UserData|null
     */
    public function getUser(): ?UserData
    {
        return $this->user;
    }

    /**
     * Sets user.
     *
     * @param OpenAPI\Server\Model\UserData|null $user
     *
     * @return $this
     */
    public function setUser(UserData $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Gets action.
     *
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * Sets action.
     *
     * @param string $action
     *
     * @return $this
     */
    public function setAction(string $action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Gets requestRoute.
     *
     * @return string|null
     */
    public function getRequestRoute(): ?string
    {
        return $this->requestRoute;
    }

    /**
     * Sets requestRoute.
     *
     * @param string|null $requestRoute
     *
     * @return $this
     */
    public function setRequestRoute(string $requestRoute = null)
    {
        $this->requestRoute = $requestRoute;

        return $this;
    }

    /**
     * Gets ipAddress.
     *
     * @return string|null
     */
    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    /**
     * Sets ipAddress.
     *
     * @param string|null $ipAddress
     *
     * @return $this
     */
    public function setIpAddress(string $ipAddress = null)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Gets eventData.
     *
     * @return string
     */
    public function getEventData(): string
    {
        return $this->eventData;
    }

    /**
     * Sets eventData.
     *
     * @param string $eventData
     *
     * @return $this
     */
    public function setEventData(string $eventData)
    {
        $this->eventData = $eventData;

        return $this;
    }
}


