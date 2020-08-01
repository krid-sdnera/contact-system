<?php

namespace App\Repository;

use App\Entity\Section;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Exception\SortKeyNotFound;
use Doctrine\ORM\ORMException;

/**
 * @method Section|null find($id, $lockMode = null, $lockVersion = null)
 * @method Section|null findOneBy(array $criteria, array $orderBy = null)
 * @method Section[]    findAll()
 * @method Section[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Section::class);
    }

    // This was implemented for preloading the scout group data.
    // TODO: find out about performance benfits of preloading the data here
    //       maybe there is an annotation to to this.
    // public function find($id, $lockMode = NULL, $lockVersion = NULL)
    // {
    //     $qb = $this->createQueryBuilder('s');
    //     $qb->select('s, sg');
    //     $qb->leftJoin('s.scoutGroup', 'sg');

    //     $qb->where('s.id = :id');
    //     $qb->setParameter('id', $id);

    //     $result = $qb->getQuery()->getResult();
    //     return $result;
    // }

    public function findByScoutGroupId($scoutGroupId)
    {
        // TODO: Add pagination
        $result = $this->createQueryBuilder('s')
            ->where('s.scoutGroup = :scoutGroupId')
            ->setParameter('scoutGroupId', $scoutGroupId)
            ->getQuery()
            ->getResult();

        return $result;
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
            $qb = $this->createQueryBuilder('s');
            $qb->select('s, sg');
            $qb->leftJoin('s.scoutGroup', 'sg');
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
    //  * @return Section[] Returns an array of Section objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Section
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
