<?php

namespace App\Repository;

use App\Entity\ScoutGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Exception\SortKeyNotFound;
use Doctrine\ORM\ORMException;

/**
 * @method ScoutGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScoutGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScoutGroup[]    findAll()
 * @method ScoutGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScoutGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ScoutGroup::class);
    }

    public function findByPage(
        $sort = null,
        $pageSize = null,
        $page = null
    ) {

        $sortComputed = [];
        if ($sort) {
            $parts = explode(':', $sort, 2);

            $sortField = (!empty($parts[0])) ? $parts[0] : null;
            if ($sortField) {
                $sortDirecton = (count($parts) >= 2 && !empty($parts[1])) ? $parts[1] : null;
                $sortComputed[strtolower($sortField)] = (in_array(strtolower($sortDirecton), ['asc', 'desc'])) ? strtolower($sortDirecton) : 'asc';
            }
        }

        $page = max($page, 1);
        $limit = max(min($pageSize, 50), 5);
        $offset = ($page - 1) * $limit;
        $offset = max(min($offset, 9999), 0);

        try {
            $qb = $this->createQueryBuilder('sg');
            $qb->select('sg');
            // TODO sortComputed
            $qb->setFirstResult($offset);
            $qb->setMaxResults($limit);

            $result = $qb->getQuery()->getResult();
        } catch (ORMException $e) {
            if (strpos($e->getMessage(), "Unrecognized field") === 0) {
                $keys = implode(',', array_keys($sortComputed));

                throw new SortKeyNotFound("Sort field (${keys}) is not found");
            }

            throw $e;
        }

        return $result;
    }

    // /**
    //  * @return ScoutGroup[] Returns an array of ScoutGroup objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ScoutGroup
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
