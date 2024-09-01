<?php

namespace App\Repository;

use App\Entity\AuditLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

use App\Repository\PageFetcherTrait;

/**
 * @method AuditLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuditLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuditLog[]    findAll()
 * @method AuditLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuditLogRepository extends ServiceEntityRepository
{
    use PageFetcherTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuditLog::class);
    }

    public function findByPage($query = null, $sort = null, $pageSize = null, $page = null)
    {
        $pageFetcher = $this->pageFetcherHelper()
            ->processPageParameters($page, $pageSize)
            ->processSortParameter($sort)
            ->processQueryParameter(
                $query,
                function (QueryBuilder $qb, $search) {
                    $qb->setParameter(":search", "%{$search}%");

                    return $qb->expr()->orX(
                        $qb->expr()->like('e.action', ':search'),
                        $qb->expr()->like('e.entityType', ':search'),
                    );
                }
            );

        return $pageFetcher->run(
            function (AuditLog $audit) {
                return $audit->toAuditData();
            },
            'audits',
            'id',
        );
    }
}
