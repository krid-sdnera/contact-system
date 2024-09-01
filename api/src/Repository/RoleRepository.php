<?php

namespace App\Repository;

use App\Entity\Role;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

use App\Repository\PageFetcherTrait;

/**
 * @method Role|null find($id, $lockMode = null, $lockVersion = null)
 * @method Role|null findOneBy(array $criteria, array $orderBy = null)
 * @method Role[]    findAll()
 * @method Role[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleRepository extends ServiceEntityRepository
{
    use PageFetcherTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Role::class);
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
                        $qb->expr()->like('e.name', ':search')
                    );
                }
            );

        return $pageFetcher->run(
            function (Role $role) {
                return $role->toRoleData();
            },
            'roles',
            'id',
        );
    }

    public function findBySectionIdPage($sectionId = null, $sort = null, $pageSize = null, $page = null)
    {
        $pageFetcher = $this->pageFetcherHelper()
            ->processPageParameters($page, $pageSize)
            ->processSortParameter($sort)
            ->addCondition(function (QueryBuilder $qb) use ($sectionId) {
                $qb->setParameter(":sectionId", $sectionId);

                return $qb->expr()->eq('e.section', ':sectionId');
            });

        return $pageFetcher->run(
            function (Role $role) {
                return $role->toRoleData();
            },
            'roles',
            'id',
        );
    }

    public function findBySectionId($sectionId)
    {
        // TODO: Add pagination
        $result = $this->createQueryBuilder('r')
            ->where('r.section = :sectionId')
            ->setParameter('sectionId', $sectionId)
            ->getQuery()
            ->getResult();

        return $result;
    }
}
