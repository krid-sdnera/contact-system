<?php
// https://davegebler.com/post/php/build-symfony-doctrine-audit-log-entity-changes

namespace App\EventSubscriber;

use App\Service\AuditLogger;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class which listens on Doctrine events and writes an audit log of any entity changes made via Doctrine.
 */
class AuditSubscriber implements EventSubscriberInterface
{

    private $auditLogger;
    private $serializer;
    private $removals = [];

    const IGNORED_ATTRIBUTES_CONTEXT = [
        'ignored_attributes' =>
            [
                'password',
                'userIdentifier',
                '__initializer__',
                '__cloner__',
                '__isInitialized__',
            ]
    ];

    static function NORMALIZE_CONTEXT()
    {
        return [
            self::IGNORED_ATTRIBUTES_CONTEXT,
            AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true,
            AbstractObjectNormalizer::MAX_DEPTH_HANDLER => function ($object, $format, $context) {
                $entityClass = ClassUtils::getClass($object);
                $entityType = str_replace('App\Entity\\', '', $entityClass);

                return "[{$entityType}] limitReached";
            },
            AbstractNormalizer::CIRCULAR_REFERENCE_LIMIT => 1,
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                $entityClass = ClassUtils::getClass($object);
                $entityType = str_replace('App\Entity\\', '', $entityClass);

                return "[{$entityType}] limitReached";
            },
        ];
    }

    // Thanks to PHP 8's constructor property promotion and 8.1's readonly properties, we can
    // simply declare our class properties here in the constructor parameter list! 
    public function __construct(
        AuditLogger $auditLogger,
        SerializerInterface $serializer,
        $removals = []
    ) {
        $this->auditLogger = $auditLogger;
        $this->serializer = $serializer;
        $this->removals = $removals;
    }

    // This function tells Symfony which Doctrine events we want to listen to.
    // The corresponding functions in this class will be called when these events are triggered.
    public function getSubscribedEvents(): array
    {
        return [
            'postPersist',
            'postUpdate',
            'preRemove',
            'postRemove',
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();
        $this->log($entity, 'create', $entityManager);
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();
        $this->log($entity, 'update', $entityManager);
    }

    // We need to store the entity in a temporary array here, because the entity's ID is no longer
    // available in the postRemove event. We convert it to an array here, so we can retain the ID for 
    // our audit log.
    public function preRemove(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $this->removals[] = $this->serializer->normalize($entity, null, self::NORMALIZE_CONTEXT());
    }

    public function postRemove(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();
        $this->log($entity, 'delete', $entityManager);
    }

    // This is the function which calls the AuditLogger service, constructing
    // the call to `AuditLogger::log()` with the appropriate parameters.
    private function log($entity, string $action, EntityManagerInterface $em): void
    {
        $entityClass = ClassUtils::getClass($entity);
        // If the class is AuditLog entity, ignore. We don't want to audit our own audit logs!
        if ($entityClass === 'App\Entity\AuditLog') {
            return;
        }

        $entityId = $entity->getId();
        $entityType = str_replace('App\Entity\\', '', $entityClass);
        $entityType = str_replace('Gesdinet\JWTRefreshTokenBundle\Entity\\', '', $entityType);

        // The Doctrine unit of work keeps track of all changes made to entities.
        $uow = $em->getUnitOfWork();
        if ($action === 'delete') {
            // For deletions, we get our entity from the temporary array.
            $entityData = array_pop($this->removals);
            $entityId = $entityData['id'];
        } elseif ($action === 'create') {
            // For insertions, we convert the entity to an array.
            $entityData = $this->serializer->normalize($entity, null, self::NORMALIZE_CONTEXT());
        } else {
            // For updates, we get the change set from Doctrine's Unit of Work manager.
            // This gives an array which contains only the fields which have
            // changed. We then just convert the numerical indexes to something
            // a bit more readable; "from" and "to" keys for the old and new values.
            $entityData = $uow->getEntityChangeSet($entity);
            foreach ($entityData as $field => $change) {

                if (is_object($change[0])) {
                    $entityData[$field][0] = $this->serializer->normalize($change[0], null, self::NORMALIZE_CONTEXT());
                }
                if (is_object($change[1])) {
                    $entityData[$field][1] = $this->serializer->normalize($change[1], null, self::NORMALIZE_CONTEXT());
                }

                $entityData[$field] = [
                    'from' => $change[0],
                    'to' => $change[1],
                ];

            }
        }
        $this->auditLogger->log($entityType, $entityId, $action, $entityData);
    }
}
