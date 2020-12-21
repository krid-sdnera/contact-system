<?php

namespace App\Repository;

use App\Exception\SortKeyNotFound;
use Doctrine\ORM\ORMException;


trait PageFetcherTrait
{

    public function pageFetcherHelper(
        $expression,
        $dataMapper,
        string $dataKey,
        string $query = null,
        string $sort = null,
        int $pageSize = null,
        int $page = null,
        string $countAggregateField = 'id'
    ) {

        // Compute sort options
        $sortComputed = [];
        if (!empty($sort)) {
            $parts = explode(':', $sort, 2);

            $sortField = (!empty($parts[0])) ? $parts[0] : null;
            if ($sortField) {
                $sortDirecton = (count($parts) >= 2 && !empty($parts[1])) ? $parts[1] : null;
                $sortComputed[$sortField] = (in_array(strtolower($sortDirecton), ['asc', 'desc'])) ? strtolower($sortDirecton) : 'asc';
            }
        }

        // Define lower and upper bounds for page sizes
        $page = max($page, 1); // 1-∞
        $pageSize = max(min($pageSize, 50), 5); // 5-50
        $offset = ($page - 1) * $pageSize;

        try {
            $qb = $this->createQueryBuilder('e');
            $qb->select('e');

            if (!empty($query)) {
                $qb->where($expression);
                $qb->setParameter('search', $query);
            }

            $qb->setFirstResult($offset);
            $qb->setMaxResults($pageSize);

            foreach ($sortComputed as $sortKey => $sortDirection) {
                $qb->orderBy("e.${sortKey}", $sortDirection);
            }

            $result = $qb->getQuery()->getResult();

            $qb = $this->createQueryBuilder('e');
            $qb->select("count(e.${countAggregateField})");

            if (!empty($query)) {
                $qb->where($expression);
                $qb->setParameter('search', $query);
            }

            $total = $qb->getQuery()->getSingleScalarResult();
        } catch (ORMException $e) {
            if (strpos($e->getMessage(), "Unrecognized field") === 0) {
                $keys = implode(',', array_keys($sortComputed));

                throw new SortKeyNotFound("Sort field (${keys}) is not found");
            }

            throw $e;
        }

        return [
            'totalItems' => (int) $total,
            'totalPages' => (int) ceil($total / $pageSize),
            'page' => $page,
            'pageSize' => $pageSize,
            $dataKey => array_map($dataMapper, $result)
        ];
    }
}
