<?php

namespace App\Repository;

use App\Entity\Member;
use App\Entity\MemberRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

use App\Repository\PageFetcherTrait;
use App\Repository\ExpiryFetcherTrait;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method Member|null find($id, $lockMode = null, $lockVersion = null)
 * @method Member|null findOneBy(array $criteria, array $orderBy = null)
 * @method Member[]    findAll()
 * @method Member[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberRepository extends ServiceEntityRepository
{
    use PageFetcherTrait;
    use ExpiryFetcherTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Member::class);
    }

    public function findByPage($query = null, $sort = null, $pageSize = null, $page = null, $constraint = null)
    {
        $customqb = $this->createQueryBuilder('e')->select('e');
        if ($constraint) {
            if (array_key_exists('roleId', $constraint)) {
                $customqb->join('e.roles', 'mr', Join::WITH, $customqb->expr()->eq('mr.role', ':role'));
                $customqb->setParameter('role', $constraint['roleId']);
            } else if (array_key_exists('sectionId', $constraint)) {
                $customqb->join('e.roles', 'mr');
                $customqb->join('mr.role', 'r');
                $customqb->join('r.section', 's', Join::WITH, $customqb->expr()->eq('s.id', ':section'));
                $customqb->setParameter('section', $constraint['sectionId']);
            }
        }

        $pageFetcher = $this->pageFetcherHelper($customqb)
            ->processPageParameters($page, $pageSize)
            ->processSortParameter($sort)
            ->processQueryParameter(
                $query,
                function (QueryBuilder $qb, $search) {
                    $qb->setParameter(":search", "%{$search}%");

                    return $qb->expr()->orX(
                        $qb->expr()->like('e.firstname', ':search'),
                        $qb->expr()->like('e.lastname', ':search'),
                        $qb->expr()->like('e.membershipNumber', ':search'),
                        $qb->expr()->like('e.email', ':search')
                    );
                }
            );

        return $pageFetcher->run(
            function (Member $member) {
                return $member->toMemberData();
            },
            'members',
            'id',
        );
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
