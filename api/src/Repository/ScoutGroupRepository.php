<?php

namespace App\Repository;

use App\Entity\ScoutGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Exception\SortKeyNotFound;
use Doctrine\ORM\ORMException;
use App\Repository\PageFetcherTrait;

/**
 * @method ScoutGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScoutGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScoutGroup[]    findAll()
 * @method ScoutGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScoutGroupRepository extends ServiceEntityRepository
{
    use PageFetcherTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ScoutGroup::class);
    }

    public function findByPage($query = null, $sort = null, $pageSize = null, $page = null)
    {
        $qb = $this->createQueryBuilder('e');
        $expression = $qb->expr()->orX(
            $qb->expr()->like('e.name', ':search')
        );
        return $this->pageFetcherHelper(
            $expression,
            function (ScoutGroup $scoutGroup) {
                return $scoutGroup->toScoutGroupData();
            },
            'scoutGroups',
            "%{$query}%",
            $sort,
            $pageSize,
            $page
        );
    }
}
