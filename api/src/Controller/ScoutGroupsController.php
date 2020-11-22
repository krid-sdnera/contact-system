<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Validator\Validator\ValidatorInterface;

use Doctrine\ORM\ORMException;

use OpenAPI\Server\Api\ScoutGroupsApiInterface;

use OpenAPI\Server\Model\ScoutGroupInput;

use App\Entity\ScoutGroup;
use App\Entity\Section;
use OpenAPI\Server\Model\ApiResponse;

use App\Exception\SortKeyNotFound;

class ScoutGroupsController extends AbstractController implements ScoutGroupsApiInterface
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
    public function createScoutGroup(ScoutGroupInput $groupInput = null, &$responseCode, array &$responseHeaders)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $newGroup = new ScoutGroup();
        $newGroup->setName($groupInput->getName());

        $entityManager->persist($newGroup);
        $entityManager->flush();

        return $newGroup->toScoutGroupData();
    }

    /**
     * {@inheritdoc}
     */
    public function deleteScoutGroupById(int $groupId, &$responseCode, array &$responseHeaders)
    {
        $group = $this->getDoctrine()
            ->getRepository(ScoutGroup::class)
            ->find($groupId);

        if (!$group) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Group (${groupId}) not found"
            ]);
        }

        $entityManager = $this->getDoctrine()->getManager();

        // TODO: Possible removal of RoleMember relations
        if (count($group->getSections()) > 0) {
            return new ApiResponse([
                'code' => 500,
                'type' => 'Group has section',
                'message' => "Group (${groupId}) was not deleted because Section records still reference this group."
            ]);
        }

        $entityManager->remove($group);
        $entityManager->flush();

        return new ApiResponse([
            'code' => 200,
            'type' => 'Group Deleted',
            'message' => "Group (${groupId}) was deleted"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getScoutGroupById(int $groupId, &$responseCode, array &$responseHeaders)
    {
        $group = $this->getDoctrine()
            ->getRepository(ScoutGroup::class)
            ->find($groupId);

        if (!$group) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Section (${groupId}) not found"
            ]);
        }

        return $group->toScoutGroupData();
    }

    /**
     * {@inheritdoc}
     */
    public function getScoutGroupSectionsById(int $scoutGroupId, &$responseCode, array &$responseHeaders)
    {

        /** @var SectionRepository */
        $sectionRepo = $this->getDoctrine()->getRepository(Section::class);

        $sections = $sectionRepo->findByScoutGroupId($scoutGroupId);

        return [
            'sections' => array_map(
                function ($section) {
                    return $section->toSectionData();
                },
                $sections
            )
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function getScoutGroups(
        $sort = null,
        $pageSize = null,
        $page = null,
        &$responseCode,
        array &$responseHeaders
    ) {
        try {
            $groups = $this->getDoctrine()
                ->getRepository(ScoutGroup::class)
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

        return [
            'scoutGroups' => array_map(
                function ($group) {
                    return $group->toScoutGroupData();
                },
                $groups
            )
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function updateScoutGroupById(int $groupId, ScoutGroupInput $groupInput = null, &$responseCode, array &$responseHeaders)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $groupToUpdate = $this->getDoctrine()
            ->getRepository(ScoutGroup::class)
            ->find($groupId);

        if (!$groupToUpdate) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Group (${groupId}) not found"
            ]);
        }

        $groupToUpdate->setName($groupInput->getName());

        $entityManager->persist($groupToUpdate);
        $entityManager->flush();

        return $groupToUpdate->toScoutGroupData();
    }
}