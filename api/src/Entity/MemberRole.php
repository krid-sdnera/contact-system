<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use DateTimeInterface;
use Exception;
use Doctrine\ORM\EntityManagerInterface;
use OpenAPI\Server\Model\MemberRoleData;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberRoleRepository")
 */
class MemberRole
{

    const DefaultManagementState = 'unmanaged';
    const DefaultState = 'enabled';
    const DefaultOverrides = [];

    const ManagementStateManaged = 'managed';
    const ManagementStateUnmanaged = 'unmanaged';

    /**
     * @var EntityManagerInterface
     */
    private static $entityManager;
    /**
     * @var LoggerInterface
     */
    private static $logger;

    public static function setEntityManager(EntityManagerInterface $entityManager)
    {
        self::$entityManager = $entityManager;
    }

    public static function setLogger(LoggerInterface $logger)
    {
        self::$logger = $logger;
    }

    public static function fromExtranetRole(Member $member, ExtranetRole $extranetRole)
    {

        if (empty(self::$entityManager) || empty(self::$logger)) {
            throw new Exception('Missing entity manager or logger in member role entity');
        }

        $logPrefix = "[member-role extranet={$extranetRole->getExternalId()}]";

        /** @var MemberRoleRepository */
        $memberRoleRepo = self::$entityManager->getRepository(self::class);

        // Get new or existing role.
        $role = Role::fromExtranetRole($extranetRole);

        self::$logger->info("{$logPrefix} Checking by member and role");
        // Lets check for a relationship entity
        /** @var MemberRole */
        $relationshipEntity = $memberRoleRepo->findOneBy([
            'member' => $member->getId(),
            'role' => $role->getId()
        ]);

        if (!$relationshipEntity) {
            $memberToString = "[member firstname={$member->getFirstname()} lastname={$member->getLastname()}]";
            $roleToString = "[role name={$extranetRole->getRoleName()} classId={$extranetRole->getNormalisedClassId()}]";
            self::$logger->info("{$logPrefix} Not found by member and role, creating member-role relation {$memberToString} {$roleToString}");
            // We can create one
            $relationshipEntity = new self();
            $relationshipEntity->setMember($member);
            $relationshipEntity->setRole($role);
            $relationshipEntity->setState(self::DefaultState);
        }

        $_loggableId = $relationshipEntity->getId() ? $relationshipEntity->getId() : 'known after creation';
        self::$logger->debug("{$logPrefix} Entity loaded at id: {$_loggableId}");

        $relationshipEntity->setManagementState(self::ManagementStateManaged);
        $relationshipEntity->setExpiry(null);

        self::$entityManager->persist($relationshipEntity);
        self::$entityManager->flush();

        return $relationshipEntity;
    }

    public function toMemberRoleData(): MemberRoleData
    {
        $arrayData = [
            'id' => $this->getId(),
            'state' => $this->getState(),
            'managementState' => $this->getManagementState(),
            'expiry' => ($this->getExpiry()) ? $this->getExpiry()->format(DateTimeInterface::ISO8601) : null,
            'memberId' => $this->getMember()->getId(),
            'role' => $this->getRole()->toRoleData(),
        ];

        $data = new MemberRoleData($arrayData);

        return $data;
    }

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Member",  inversedBy="roles")
     * @MaxDepth(1)
     */
    private $member;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Role",  inversedBy="members")
     * @ORM\JoinColumn(nullable=false)
     * @MaxDepth(1)
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=255, options={"default": "enabled"})
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255, options={"default": "unmanaged"})
     */
    private $managementState;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $expiry;

    public function getId(): ?string
    {
        return $this->member->getId() . '-' . $this->role->getId();
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        $this->member = $member;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getManagementState(): ?string
    {
        return $this->managementState;
    }

    public function setManagementState(string $managementState): self
    {
        $this->managementState = $managementState;

        return $this;
    }

    public function getExpiry(): ?\DateTimeInterface
    {
        return $this->expiry;
    }

    public function setExpiry(?\DateTimeInterface $expiry): self
    {
        $this->expiry = $expiry;

        return $this;
    }
}
