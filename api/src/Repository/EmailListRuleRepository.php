<?php

namespace App\Repository;

use App\Entity\EmailListRule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
        $qb = $this->createQueryBuilder('e')->select('e');
        if ($constraint) {

            if (array_key_exists('listId', $constraint)) {
                $qb->where($qb->expr()->eq('e.emailList', ':list'));
                $qb->setParameter('list', $constraint['listId']);
            } else if (array_key_exists('contactId', $constraint)) {
                $qb->where($qb->expr()->eq('e.contact', ':contact'));
                $qb->setParameter('contact', $constraint['contactId']);
            } else if (array_key_exists('memberId', $constraint)) {
                $qb->where($qb->expr()->eq('e.member', ':member'));
                $qb->setParameter('member', $constraint['memberId']);
            } else if (array_key_exists('roleId', $constraint)) {
                $qb->where($qb->expr()->eq('e.role', ':role'));
                $qb->setParameter('role', $constraint['roleId']);
            } else if (array_key_exists('sectionId', $constraint)) {
                $qb->where($qb->expr()->eq('e.section', ':section'));
                $qb->setParameter('section', $constraint['sectionId']);
            } else if (array_key_exists('scoutGroupId', $constraint)) {
                $qb->where($qb->expr()->eq('e.scoutGroup', ':scoutGroup'));
                $qb->setParameter('scoutGroup', $constraint['scoutGroupId']);
            }
        }

        $expression = $qb->expr()->orX(
            $qb->expr()->like('e.label', ':search'),
            $qb->expr()->like('e.comment', ':search'),
        );

        return $this->pageFetcherHelper(
            $expression,
            function (EmailListRule $emailListMem) {
                return $emailListMem->toListRuleData();
            },
            'rules',
            "%${query}%",
            $sort,
            $pageSize,
            $page,
            'id',
            $qb
        );
    }
}
