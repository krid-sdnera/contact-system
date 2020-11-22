<?php

namespace App\Repository;

use App\Entity\Member;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Exception\SortKeyNotFound;
use Doctrine\ORM\ORMException;

/**
 * @method Member|null find($id, $lockMode = null, $lockVersion = null)
 * @method Member|null findOneBy(array $criteria, array $orderBy = null)
 * @method Member[]    findAll()
 * @method Member[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Member::class);
    }

    public function findByPage(
        $query = null,
        $sort = null,
        $pageSize = null,
        $page = null
    ) {

        $sortComputed = [];
        if (!empty($sort)) {
            $parts = explode(':', $sort, 2);

            $sortField = (!empty($parts[0])) ? $parts[0] : null;
            if ($sortField) {
                $sortDirecton = (count($parts) >= 2 && !empty($parts[1])) ? $parts[1] : null;
                $sortComputed[$sortField] = (in_array(strtolower($sortDirecton), ['asc', 'desc'])) ? strtolower($sortDirecton) : 'asc';
            }
        }

        $page = max($page, 1);
        $limit = max(min($pageSize, 50), 5);
        $offset = ($page - 1) * $limit;
        $offset = max(min($offset, 9999), 0);

        try {
            $qb = $this->createQueryBuilder('m');
            $qb->select('m');


            // if (!empty($query)) {
            //     $qb->add('where', $qb->expr()->orX(
            //         $qb->expr()->like('m.firstname', ':search'),
            //         $qb->expr()->like('m.surname', ':search'),
            //         $qb->expr()->like('m.membershipNumber', ':search')
            //     ));
            //     $qb->setParameter('search', '%' . $query . '%');
            // }

            foreach ($sortComputed as $sortKey => $sortDirection) {
                $qb->orderBy('m.' . $sortKey, $sortDirection);
            }


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

    public function findIdsBy(array $criteria)
    {

        $queryBuilder = $this->createQueryBuilder('m');
        $queryBuilder->select('m.id');

        foreach ($criteria as $key => $value) {
            if (\is_array($value)) {
                $exp = $queryBuilder->expr()->in("m.{$key}", ":{$key}");
            } else {
                $exp = $queryBuilder->expr()->eq("m.{$key}", ":{$key}");
            }

            $queryBuilder
                ->andWhere($exp)
                ->setParameter($key, $value);
        }

        $result = $queryBuilder->getQuery()->getScalarResult();

        $ids = array_column($result, "id");

        return $ids;
    }

    // public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    // {
    //     $queryBuilder = $this->createQueryBuilder('p');

    //     foreach ($criteria as $key => $value) {
    //         if (\is_array($value)) {
    //             $exp = $queryBuilder->expr()->in("e.{$key}", ":{$key}");
    //         } else {
    //             $exp = $queryBuilder->expr()->eq("e.{$key}", ":{$key}");
    //         }

    //         $queryBuilder
    //             ->andWhere($exp)
    //             ->setParameter($key, $value)
    //         ;
    //     }

    //     foreach ($orderBy ?: [] as $sort => $order) {
    //         $queryBuilder->orderBy("e.{$sort}", $order);
    //     }

    //     if ($limit) {
    //         $queryBuilder->setMaxResults($limit);
    //     }

    //     if ($offset) {
    //         $queryBuilder->setFirstResult($offset);
    //     }

    //     $query = $queryBuilder->getQuery();

    //     $query
    //         ->useQueryCache(false)
    //         ->setHint(\Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER, TranslationWalker::class)
    //         ->setHint(\Gedmo\Translatable\TranslatableListener::HINT_FALLBACK, 1)
    //     ;

    //     return $query->getResult();
    // }

    // /**
    //  * @return Member[] Returns an array of Member objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Member
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
