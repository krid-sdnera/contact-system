<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Repository\PageFetcherTrait;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    use PageFetcherTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    public function findByPage($query = null, $sort = null, $pageSize = null, $page = null)
    {
        $qb = $this->createQueryBuilder('e');
        $expression = $qb->expr()->orX(
            $qb->expr()->like('e.firstname', ':search'),
            $qb->expr()->like('e.lastname', ':search'),
            $qb->expr()->like('e.email', ':search')
        );
        return $this->pageFetcherHelper(
            $expression,
            function (Contact $contact) {
                return $contact->toContactData();
            },
            'contacts',
            "%${query}%",
            $sort,
            $pageSize,
            $page
        );
    }

    public function findByMemberIdPage($memberId = null, $sort = null, $pageSize = null, $page = null)
    {
        $qb = $this->createQueryBuilder('e');
        $expression = $qb->expr()->orX(
            $qb->expr()->eq('e.member', ':search')
        );
        return $this->pageFetcherHelper(
            $expression,
            function (Contact $contact) {
                return $contact->toContactData();
            },
            'contacts',
            $memberId,
            $sort,
            $pageSize,
            $page
        );
    }
}
