<?php

namespace App\Repository;

use App\Entity\EmailListRule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

use App\Repository\PageFetcherTrait;

/**
 * @method EmailListRule|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmailListRule|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmailListRule[]    findAll()
 * @method EmailListRule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailListRuleRepository extends ServiceEntityRepository
{
    use PageFetcherTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailListRule::class);
    }

    public function findByPage($query = null, $sort = null, $pageSize = null, $page = null, $constraint = null)
    {
        $pageFetcher = $this->pageFetcherHelper()
            ->processPageParameters($page, $pageSize)
            ->processSortParameter($sort)
            ->processQueryParameter(
                $query,
                function (QueryBuilder $qb, $search) {
                    $qb->setParameter(":search", "%{$search}%");

                    return $qb->expr()->orX(
                        $qb->expr()->like('e.label', ':search'),
                        $qb->expr()->like('e.comment', ':search'),
                    );
                }
            )
            ->addCondition(function (QueryBuilder $qb) use ($constraint) {
                if (empty($constraint)) {
                    return null;
                }

                if (array_key_exists('listId', $constraint)) {
                    $qb->setParameter('list', $constraint['listId']);
                    return $qb->expr()->eq('e.emailList', ':list');
                } else if (array_key_exists('contactId', $constraint)) {
                    $qb->setParameter('contact', $constraint['contactId']);
                    return $qb->expr()->eq('e.contact', ':contact');
                } else if (array_key_exists('memberId', $constraint)) {
                    $qb->setParameter('member', $constraint['memberId']);
                    return $qb->expr()->eq('e.member', ':member');
                } else if (array_key_exists('roleId', $constraint)) {
                    $qb->setParameter('role', $constraint['roleId']);
                    return $qb->expr()->eq('e.role', ':role');
                } else if (array_key_exists('sectionId', $constraint)) {
                    $qb->setParameter('section', $constraint['sectionId']);
                    return $qb->expr()->eq('e.section', ':section');
                } else if (array_key_exists('scoutGroupId', $constraint)) {
                    $qb->setParameter('scoutGroup', $constraint['scoutGroupId']);
                    return $qb->expr()->eq('e.scoutGroup', ':scoutGroup');
                }

                return null;
            });

        return $pageFetcher->run(
            function (EmailListRule $emailListMem) {
                return $emailListMem->toListRuleData();
            },
            'rules',
            'id',
        );
    }
}
