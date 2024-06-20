<?php

namespace App\Repository;

use App\Entity\Section;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Exception\SortKeyNotFound;
use Doctrine\ORM\ORMException;
use App\Repository\PageFetcherTrait;

/**
 * @method Section|null find($id, $lockMode = null, $lockVersion = null)
 * @method Section|null findOneBy(array $criteria, array $orderBy = null)
 * @method Section[]    findAll()
 * @method Section[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectionRepository extends ServiceEntityRepository
{
    use PageFetcherTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Section::class);
    }

    public function findByPage($query = null, $sort = null, $pageSize = null, $page = null)
    {
        $qb = $this->createQueryBuilder('e');
        $expression = $qb->expr()->orX(
            $qb->expr()->like('e.name', ':search')
        );
        return $this->pageFetcherHelper(
            $expression,
            function (Section $section) {
                return $section->toSectionData();
            },
            'sections',
            "%{$query}%",
            $sort,
            $pageSize,
            $page
        );
    }

    public function findByScoutGroupIdPage($scoutGroupId = null, $sort = null, $pageSize = null, $page = null)
    {
        $qb = $this->createQueryBuilder('e');
        $expression = $qb->expr()->orX(
            $qb->expr()->eq('e.scoutGroup', ':search')
        );
        return $this->pageFetcherHelper(
            $expression,
            function (Section $section) {
                return $section->toSectionData();
            },
            'sections',
            $scoutGroupId,
            $sort,
            $pageSize,
            $page
        );
    }
}
