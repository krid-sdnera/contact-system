<?php

namespace App\Repository;

use App\Entity\MemberRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

use App\Repository\PageFetcherTrait;
use App\Repository\ExpiryFetcherTrait;

/**
 * @method MemberRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method MemberRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method MemberRole[]    findAll()
 * @method MemberRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberRoleRepository extends ServiceEntityRepository
{
    use PageFetcherTrait;
    use ExpiryFetcherTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MemberRole::class);
    }

    public function findByMemberIdPage($memberId = null, $sort = null, $pageSize = null, $page = null)
    {
        $pageFetcher = $this->pageFetcherHelper()
            ->processPageParameters($page, $pageSize)
            ->processSortParameter($sort)
            ->addCondition(function (QueryBuilder $qb) use ($memberId) {
                $qb->setParameter(":memberId", $memberId);

                return $qb->expr()->eq('e.member', ':memberId');
            });

        return $pageFetcher->run(
            function (MemberRole $memberRole) {
                return $memberRole->toMemberRoleData();
            },
            'roles',
            'member'
        );
    }
}
