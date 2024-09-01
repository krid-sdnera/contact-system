<?php

namespace App\Repository;

use App\Exception\SortKeyNotFound;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;

trait PageFetcherTrait
{
    public function pageFetcherHelper(QueryBuilder $customQb = null)
    {
        $qb = $customQb ?: $this->createQueryBuilder('e')->select('e');
        $pageFetcher = new PageFetcher($qb);

        return $pageFetcher;
    }
}


class PageFetcher
{
    /**
     * @var QueryBuilder
     */
    private $qb;

    private $page;
    private $pageSize;
    private $sort = [];
    private $expressions = [];

    public function __construct(QueryBuilder $qb)
    {
        $this->qb = $qb;
    }

    function processPageParameters($page, $pageSize): self
    {
        // Define lower and upper bounds for page sizes
        $this->page = max($page, 1); // 1-∞
        $this->pageSize = max(min($pageSize, 50), 5); // 5-50

        return $this;
    }

    function processSortParameter($sortString): self
    {
        // Compute sort options
        // $sortString = "fieldName1:asc,fieldName2:asc,"
        // $this->sort = ['fieldName1'=>'asc','fieldName2'=>'asc']

        if (!empty($sortString)) {
            $sortParts = explode(',', $sortString);
            foreach ($sortParts as $sortPart) {
                $parts = explode(':', $sortPart, 2);

                $sortField = (!empty($parts[0])) ? $parts[0] : null;
                if ($sortField) {
                    $sortDirecton = (count($parts) >= 2 && !empty($parts[1])) ? $parts[1] : null;
                    $this->sort[$sortField] = (in_array(strtolower($sortDirecton), ['asc', 'desc'])) ? strtolower($sortDirecton) : 'asc';
                }
            }
        }

        return $this;
    }

    function processQueryParameter($queryString, $searchBuilderFn): self
    {
        $queryParsed = PageFetcher::parseQueryFilters($queryString);
        foreach ($queryParsed['filters'] as $filterKey => $filterValue) {
            if (empty($filterValue)) {
                continue;
            }

            $this->expressions[] = $this->qb->expr()->like("e.{$filterKey}", ":param{$filterKey}");
            $this->qb->setParameter(":param{$filterKey}", "%{$filterValue}%");
        }

        if (!empty($queryParsed['search'])) {
            $this->expressions[] = $searchBuilderFn($this->qb, $queryParsed['search']);
        }

        return $this;
    }

    private static function parseQueryFilters($queryStr)
    {
        // check if query can be parsed as a json object.
        $query = ['search' => "", 'filters' => []];
        try {
            $jsonObj = json_decode($queryStr, true, 512, JSON_THROW_ON_ERROR);

            if (!empty($jsonObj['search'])) {
                $query['search'] = $jsonObj['search'];
            }
            if (!empty($jsonObj['filters'])) {
                $query['filters'] = $jsonObj['filters'];
            }
        } catch (\JsonException $e) {
            $query['search'] = $queryStr;
        }

        return $query;
    }

    function addCondition($searchBuilderFn): self
    {
        $res = $searchBuilderFn($this->qb);
        if ($res !== null) {
            $this->expressions[] = $res;
        }

        return $this;
    }

    function run($dataMapper, string $dataKey, string $countAggregateField)
    {
        try {
            if (count($this->expressions) > 0) {
                $this->qb->where(
                    $this->qb->expr()->andX(...$this->expressions)
                );
            }

            // Clone before applying pagination offset and limits.
            $cloned = clone $this->qb;

            $offset = ($this->page - 1) * $this->pageSize;
            $this->qb->setFirstResult($offset);
            $this->qb->setMaxResults($this->pageSize);

            foreach ($this->sort as $sortKey => $sortDirection) {
                $this->qb->orderBy("e.{$sortKey}", $sortDirection);
            }

            $result = $this->qb->getQuery()->getResult();

            $cloned->select("count(e.{$countAggregateField})");
            $total = $cloned->getQuery()->getSingleScalarResult();
        } catch (ORMException $e) {
            if (strpos($e->getMessage(), "Unrecognized field") === 0) {
                $keys = implode(',', array_keys($this->sort));

                throw new SortKeyNotFound("Sort field ({$keys}) is not found");
            }

            throw $e;
        }

        return [
            'totalItems' => (int) $total,
            'totalPages' => (int) ceil($total / $this->pageSize),
            'page' => $this->page,
            'pageSize' => $this->pageSize,
            $dataKey => array_map($dataMapper, $result)
        ];
    }
}
