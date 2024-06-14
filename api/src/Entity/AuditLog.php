<?php

namespace App\Entity;

use App\Repository\AuditLogRepository;
use Doctrine\ORM\Mapping as ORM;
use OpenAPI\Server\Model\AuditData;
use DateTimeInterface;
use OpenAPI\Server\Model\UserData;

/**
 * @ORM\Entity(repositoryClass=AuditLogRepository::class)
 */
class AuditLog
{

    public function toAuditData(): AuditData
    {
        $arrayData = [
            'id' => $this->getId(),
            'entityType' => $this->getEntityType(),
            'entityId' => $this->getEntityId(),
            'createdAt' => ($this->getCreatedAt()) ? $this->getCreatedAt()->format(DateTimeInterface::ISO8601) : null,
            'user' => $this->getUser()
                ? new UserData([
                    'id' => $this->getUser()->getId(),
                    'username' => $this->getUser()->getUsername()
                ])
                : new UserData(['id' => 0, 'username' => 'cron']),
            'action' => $this->getAction(),
            'requestRoute' => $this->getRequestRoute(),
            'ipAddress' => $this->getIpAddress(),
            'eventData' => json_encode($this->getEventData()),
        ];

        // print_r($this->getEventData());

        $data = new AuditData($arrayData);

        return $data;
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $entityType;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $entityId;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="auditLogs")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $action;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $requestRoute;

    /**
     * @ORM\Column(type="json")
     */
    private $eventData = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ipAddress;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntityType(): ?string
    {
        return $this->entityType;
    }

    public function setEntityType(?string $entityType): self
    {
        $this->entityType = $entityType;

        return $this;
    }

    public function getEntityId(): ?string
    {
        return $this->entityId;
    }

    public function setEntityId(?string $entityId): self
    {
        $this->entityId = $entityId;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getRequestRoute(): ?string
    {
        return $this->requestRoute;
    }

    public function setRequestRoute(?string $requestRoute): self
    {
        $this->requestRoute = $requestRoute;

        return $this;
    }

    public function getEventData(): ?array
    {
        return $this->eventData;
    }

    public function setEventData(array $eventData): self
    {
        $this->eventData = $eventData;

        return $this;
    }

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(?string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }
}
