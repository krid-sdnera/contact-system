<?php

namespace App\Controller;

use App\Entity\EmailListRule;
use App\Entity\ScoutGroup;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Validator\Validator\ValidatorInterface;


use OpenAPI\Server\Api\SectionsApiInterface;

use OpenAPI\Server\Model\SectionInput;

use App\Entity\Member;
use App\Entity\Section;
use App\Entity\Role;
use OpenAPI\Server\Model\ApiResponse;

use App\Exception\SortKeyNotFound;
use App\Repository\EmailListRuleRepository;

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
    public function setjwt_auth($value)
    {
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

        return [
            'success' => true,
            'section' => $newSection->toSectionData(),
        ];
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
    public function getMembersBySectionId(int $sectionId, string $query = null, string $sort = null, int $pageSize = null, int $page = null, &$responseCode, array &$responseHeaders)
    {
        /** @var MemberRepository */
        $repo = $this->getDoctrine()->getRepository(Member::class);

        try {
            $result = $repo->findByPage(
                $query,
                $sort,
                $pageSize,
                $page,
                ['sectionId' => $sectionId]
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

        return [
            'success' => true,
            'section' => $section->toSectionData(),
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function getSectionRolesBySectionId(int $sectionId, &$responseCode, array &$responseHeaders)
    {

        /** @var RoleRepository */
        $roleRepo = $this->getDoctrine()->getRepository(Role::class);

        $roles = $roleRepo->findBySectionId($sectionId);

        return [
            'roles' => array_map(
                function ($role) {
                    return $role->toRoleData();
                },
                $roles
            )
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getSections(
        $query = null,
        $sort = null,
        $pageSize = null,
        $page = null,
        &$responseCode,
        array &$responseHeaders
    ) {

        /** @var SectionRepository */
        $repo = $this->getDoctrine()->getRepository(Section::class);

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

    /**
     * {@inheritdoc}
     */
    public function getListRulesBySectionId(int $sectionId, string $query = null, string $sort = null, int $pageSize = null, int $page = null, &$responseCode, array &$responseHeaders)
    {
        /** @var EmailListRuleRepository */
        $repo = $this->getDoctrine()->getRepository(EmailListRule::class);

        try {
            $result = $repo->findByPage(
                $query,
                $sort,
                $pageSize,
                $page,
                ['sectionId' => $sectionId]
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

        return [
            'success' => true,
            'section' => $sectionToUpdate->toSectionData(),
        ];
    }
}
