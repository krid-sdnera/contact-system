<?php

namespace App\Repository;

use App\Entity\EmailList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Repository\PageFetcherTrait;

/**
 * @method EmailList|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmailList|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmailList[]    findAll()
 * @method EmailList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailListRepository extends ServiceEntityRepository
{
    use PageFetcherTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailList::class);
    }

    public function findByPage($query = null, $sort = null, $pageSize = null, $page = null)
    {
        $qb = $this->createQueryBuilder('e');
        $expression = $qb->expr()->like('e.address', ':search');

        return $this->pageFetcherHelper(
            $expression,
            function (EmailList $emailList) {
                return $emailList->toListData();
            },
            'lists',
            "%{$query}%",
            $sort,
            $pageSize,
            $page
        );
    }
}
