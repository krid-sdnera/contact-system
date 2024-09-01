<?php

namespace App\Repository;

use App\Entity\Section;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
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
            function (Section $section) {
                return $section->toSectionData();
            },
            'sections',
            'id',
        );
    }

    public function findByScoutGroupIdPage($scoutGroupId = null, $sort = null, $pageSize = null, $page = null)
    {

        $pageFetcher = $this->pageFetcherHelper()
            ->processPageParameters($page, $pageSize)
            ->processSortParameter($sort)
            ->addCondition(function (QueryBuilder $qb) use ($scoutGroupId) {
                $qb->setParameter(":scoutGroupId", $scoutGroupId);

                return $qb->expr()->eq('e.scoutGroup', ':scoutGroupId');
            });

        return $pageFetcher->run(
            function (Section $section) {
                return $section->toSectionData();
            },
            'sections',
            'id',
        );

    }
}
