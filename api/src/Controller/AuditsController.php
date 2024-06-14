<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use OpenAPI\Server\Api\AuditsApiInterface;

use App\Entity\AuditLog;
use OpenAPI\Server\Model\ApiResponse;

use App\Exception\SortKeyNotFound;
use App\Repository\AuditLogRepository;

class AuditsController extends AbstractController implements AuditsApiInterface
{

    /**
     * {@inheritdoc}
     */
    public function setcontact_auth($value)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function setjwt_auth($value)
    {
    }


    /**
     * {@inheritdoc}
     */
    public function getAudits(
        $query = null,
        $sort = null,
        $pageSize = null,
        $page = null,
        &$responseCode,
        array &$responseHeaders
    ) {

        /** @var AuditLogRepository */
        $repo = $this->getDoctrine()->getRepository(AuditLog::class);

        try {
            $result = $repo->findByPage(
                $query,
                $sort,
                $pageSize,
                $page
            );

            return $result;
        } catch (SortKeyNotFound $e) {
            $responseCode = 400;
            return new ApiResponse([
                'code' => 400,
                'type' => 'Bad Request',
                'message' => $e->getMessage()
            ]);
        }
    }
}
