<?php

namespace App\Repository;

use App\Entity\EmailListRecipient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use App\Repository\PageFetcherTrait;

/**
 * @method EmailListRecipient|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmailListRecipient|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmailListRecipient[]    findAll()
 * @method EmailListRecipient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailListRecipientRepository extends ServiceEntityRepository
{
    use PageFetcherTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailListRecipient::class);
    }
}
