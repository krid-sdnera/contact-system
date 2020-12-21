<?php

namespace App\Repository;

use App\Entity\Role;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
        $qb = $this->createQueryBuilder('e');
        $expression = $qb->expr()->orX(
            $qb->expr()->like('e.name', ':search')
        );
        return $this->pageFetcherHelper(
            $expression,
            function (Role $role) {
                return $role->toRoleData();
            },
            'roles',
            "%${query}%",
            $sort,
            $pageSize,
            $page
        );
    }

    public function findBySectionIdPage($sectionId = null, $sort = null, $pageSize = null, $page = null)
    {
        $qb = $this->createQueryBuilder('e');
        $expression = $qb->expr()->orX(
            $qb->expr()->like('e.section', ':search')
        );
        return $this->pageFetcherHelper(
            $expression,
            function (Role $role) {
                return $role->toRoleData();
            },
            'roles',
            $sectionId,
            $sort,
            $pageSize,
            $page
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
