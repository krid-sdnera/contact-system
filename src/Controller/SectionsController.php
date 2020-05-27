<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Validator\Validator\ValidatorInterface;

use Doctrine\ORM\ORMException;

use OpenAPI\Server\Api\SectionsApiInterface;

use OpenAPI\Server\Model\SectionInput;

use App\Entity\Section;
use OpenAPI\Server\Model\ApiResponse;

class SectionsController extends AbstractController implements SectionsApiInterface
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
    public function addSectionLocalMarkerById($sectionId, &$responseCode, array &$responseHeaders)
    {
        $responseCode = 501;
        return new ApiResponse([
            'code' => 501,
            'type' => 'Not Implemented',
            'message' => "This endpoint has not been implemented"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function createSection(SectionInput $section = null, &$responseCode, array &$responseHeaders)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $newSection = new Section();
        $newSection->setName($section->getName());

        // $errors = $validator->validate($product);
        // if (count($errors) > 0) {
        //     $responseCode = 400;
        //     return (string) $errors;
        // }

        $entityManager->persist($newSection);
        $entityManager->flush();

        return $newSection;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteSectionById($sectionId, &$responseCode, array &$responseHeaders)
    {
        $section = $this->getDoctrine()
            ->getRepository(Section::class)
            ->find($sectionId);

        if (!$section) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Section (${sectionId}) not found"
            ]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($section);
        $entityManager->flush();

        return new ApiResponse([
            'code' => 200,
            'type' => 'Section Deleted',
            'message' => "Section (${sectionId}) was deleted"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getSectionById($sectionId, &$responseCode, array &$responseHeaders)
    {
        $section = $this->getDoctrine()
            ->getRepository(Section::class)
            ->find($sectionId);

        if (!$section) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Section (${sectionId}) not found"
            ]);
        }

        return $section;
    }

    /**
     * {@inheritdoc}
     */
    public function getSectionMembersById($sectionId, &$responseCode, array &$responseHeaders)
    {
        $responseCode = 501;
        return new ApiResponse([
            'code' => 501,
            'type' => 'Not Implemented',
            'message' => "This endpoint has not been implemented"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getSections(
        $sort = null,
        $pageSize = null,
        $page = null,
        &$responseCode,
        array &$responseHeaders
    ) {
        $sortComputed = [];
        if ($sort) {
            $parts = explode(':', $sort, 2);

            $sortField = (!empty($parts[0])) ? $parts[0] : null;
            if ($sortField) {
                $sortDirecton = (count($parts) >= 2 && !empty($parts[1])) ? $parts[1] : null;
                $sortComputed[strtolower($sortField)] = (in_array(strtolower($sortDirecton), ['asc', 'desc'])) ? strtolower($sortDirecton) : 'asc';
            }
        }

        $page = max($page, 1);
        $limit = max(min($pageSize, 50), 5);
        $offset = ($page - 1) * $limit;
        $offset = max(min($offset, 9999), 0);

        try {
            $sections = $this->getDoctrine()
                ->getRepository(Section::class)
                ->findBy([], $sortComputed, $limit, $offset);
        } catch (ORMException $e) {
            if (strpos($e->getMessage(), "Unrecognized field") === 0) {
                $keys = implode(',', array_keys($sortComputed));

                $responseCode = 400;
                return new ApiResponse([
                    'code' => 400,
                    'type' => 'Bad Request',
                    'message' => "Sort field (${keys}) is not found"
                ]);
            }

            throw $e;
        }

        return $sections;
    }

    /**
     * {@inheritdoc}
     */
    public function removeSectionLocalMarkerById($sectionId, &$responseCode, array &$responseHeaders)
    {
        $responseCode = 501;
        return new ApiResponse([
            'code' => 501,
            'type' => 'Not Implemented',
            'message' => "This endpoint has not been implemented"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function updateSectionById($sectionId, SectionInput $section = null, &$responseCode, array &$responseHeaders)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $sectionToUpdate = $this->getDoctrine()
            ->getRepository(Section::class)
            ->find($sectionId);

        if (!$sectionToUpdate) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Section (${sectionId}) not found"
            ]);
        }

        $sectionToUpdate->setName($section->getName());


        // $errors = $validator->validate($product);
        // if (count($errors) > 0) {
        //     $responseCode = 400;
        //     return (string) $errors;
        // }

        $entityManager->persist($sectionToUpdate);
        $entityManager->flush();

        return $sectionToUpdate;
    }
}
