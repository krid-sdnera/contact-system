<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

use App\Repository\PageFetcherTrait;
use App\Repository\ExpiryFetcherTrait;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    use PageFetcherTrait;
    use ExpiryFetcherTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
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
                        $qb->expr()->like('e.firstname', ':search'),
                        $qb->expr()->like('e.lastname', ':search'),
                        $qb->expr()->like('e.email', ':search')
                    );
                }
            );

        return $pageFetcher->run(
            function (Contact $contact) {
                return $contact->toContactData();
            },
            'contacts',
            'id',
        );
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
            function (Contact $contact) {
                return $contact->toContactData();
            },
            'contacts',
            'id',
        );
    }
}
