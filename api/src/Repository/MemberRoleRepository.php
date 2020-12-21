<?php

namespace App\Repository;

use App\Entity\MemberRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\PageFetcherTrait;

/**
 * @method MemberRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method MemberRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method MemberRole[]    findAll()
 * @method MemberRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberRoleRepository extends ServiceEntityRepository
{
    use PageFetcherTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MemberRole::class);
    }

    public function findByMemberIdPage($memberId = null, $sort = null, $pageSize = null, $page = null)
    {
        $qb = $this->createQueryBuilder('e');
        $expression = $qb->expr()->orX(
            $qb->expr()->eq('e.member', ':search')
        );
        return $this->pageFetcherHelper(
            $expression,
            function (MemberRole $memberRole) {
                return $memberRole->toMemberRoleData();
            },
            'roles',
            $memberId,
            $sort,
            $pageSize,
            $page,
            'member'
        );
    }
}
