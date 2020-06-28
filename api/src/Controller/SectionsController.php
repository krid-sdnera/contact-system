<?php

namespace App\Controller;

use App\Entity\ScoutGroup;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Validator\Validator\ValidatorInterface;


use OpenAPI\Server\Api\SectionsApiInterface;

use OpenAPI\Server\Model\SectionInput;

use App\Entity\Section;
use OpenAPI\Server\Model\ApiResponse;

use App\Exception\SortKeyNotFound;

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

        $groupId = $section->getScoutGroupId();
        $group = $this->getDoctrine()
            ->getRepository(ScoutGroup::class)
            ->find($groupId);

        if (!$group) {
            $responseCode = 500;
            return new ApiResponse([
                'code' => 500,
                'type' => 'Constraint not met',
                'message' => "Group (${groupId}) required for section creation and was not found"
            ]);
        }

        $newSection = new Section();
        $newSection->setName($section->getName());
        $newSection->setScoutGroup($group);

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

        // TODO: Possible removal of RoleMember relations
        if (count($section->getRoles()) > 0) {
            return new ApiResponse([
                'code' => 500,
                'type' => 'Section has roles',
                'message' => "Section (${sectionId}) was not deleted because Role records still reference this section."
            ]);
        }

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
        try {
            $sections = $this->getDoctrine()
                ->getRepository(Section::class)
                ->findByPage(
                    $sort,
                    $pageSize,
                    $page
                );
        } catch (SortKeyNotFound $e) {
            $responseCode = 400;
            return new ApiResponse([
                'code' => 400,
                'type' => 'Bad Request',
                'message' => $e->getMessage()
            ]);
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

        $groupId = $section->getScoutGroupId();
        $group = $this->getDoctrine()
            ->getRepository(ScoutGroup::class)
            ->find($groupId);

        if (!$group) {
            $responseCode = 500;
            return new ApiResponse([
                'code' => 500,
                'type' => 'Constraint not met',
                'message' => "Group (${groupId}) required for section creation and was not found"
            ]);
        }

        $sectionToUpdate->setName($section->getName());
        $sectionToUpdate->setScoutGroup($group);

        $entityManager->persist($sectionToUpdate);
        $entityManager->flush();

        return $sectionToUpdate;
    }
}