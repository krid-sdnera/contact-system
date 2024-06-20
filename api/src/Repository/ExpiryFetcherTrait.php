<?php

namespace App\Repository;

trait ExpiryFetcherTrait
{
    public function findExpiredEntities(string $interval)
    {
        $expiry = new \DateTime();
        $expiry->modify($interval);

        return $this->createQueryBuilder('e')
            ->select('e')
            ->andWhere('e.expiry < :expiry')
            ->setParameter(':expiry', $expiry)
            ->getQuery()
            ->getResult();
    }
}
