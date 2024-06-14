<?php

namespace App\Service;

use App\Entity\AuditLog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

class AuditLogger
{
    private $em;
    private $security;
    private $requestStack;

    public function __construct(EntityManagerInterface $entityManager, Security $security, RequestStack $requestStack)
    {
        $this->em = $entityManager;
        $this->security = $security;
        $this->requestStack = $requestStack;
    }

    public function log(string $entityType, string $entityId, string $action, array $eventData): void
    {
        $user = $this->security->getUser();
        $request = $this->requestStack->getCurrentRequest();
        $auditLog = new AuditLog;
        $auditLog->setEntityType($entityType);
        $auditLog->setEntityId($entityId);
        $auditLog->setAction($action);
        $auditLog->setEventData($eventData);
        $auditLog->setUser($user);
        $auditLog->setRequestRoute($request !== null ? $request->get('_route') : null);
        $auditLog->setIpAddress($request !== null ? $request->getClientIp() : null);
        $auditLog->setCreatedAt(new \DateTimeImmutable);

        // Its apparently not best practice to flush the entity manager within a postUpdate.
        // $this->em->persist($log);
        // $this->em->flush();

        // Handle row insertion manually.
        $dbal = $this->em->getConnection();
        try {
            $dbal->beginTransaction();
            $dbal->insert('audit_log', [
                'entity_type' => $auditLog->getEntityType(),
                'entity_id' => $auditLog->getEntityId(),
                'action' => $auditLog->getAction(),
                'event_data' => json_encode($auditLog->getEventData()),
                'user_id' => $auditLog->getUser() ? $auditLog->getUser()->getId() : null,
                'request_route' => $auditLog->getRequestRoute(),
                'ip_address' => $auditLog->getIpAddress(),
                'created_at' => $auditLog->getCreatedAt()->format('Y-m-d H:i:s'),
            ]);
            $dbal->commit();
        } catch (Exception $e) {
            // rollback and log system error 
        }
    }
}
