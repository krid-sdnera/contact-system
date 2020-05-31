<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Validator\Validator\ValidatorInterface;

use Doctrine\ORM\ORMException;

use OpenAPI\Server\Api\GroupsApiInterface;

use OpenAPI\Server\Model\GroupInput;

use App\Entity\ScoutGroup;
use App\Entity\Section;
use OpenAPI\Server\Model\ApiResponse;

use App\Exception\SortKeyNotFound;

class GroupsController extends AbstractController implements GroupsApiInterface
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
    public function addGroupLocalMarkerById(string $groupId, &$responseCode, array &$responseHeaders)
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
    public function createGroup(GroupInput $groupInput = null, &$responseCode, array &$responseHeaders)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $newGroup = new ScoutGroup();
        $newGroup->setName($groupInput->getName());

        $entityManager->persist($newGroup);
        $entityManager->flush();

        return $newGroup;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteGroupById(string $groupId, &$responseCode, array &$responseHeaders)
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
    public function deleteGroupLocalMarkerById(string $groupId, &$responseCode, array &$responseHeaders)
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
    public function getGroupById(string $groupId, &$responseCode, array &$responseHeaders)
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

        return $group;
    }

    /**
     * {@inheritdoc}
     */
    public function getGroupMembersById(string $groupId, &$responseCode, array &$responseHeaders)
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
    public function getGroupSectionsById(string $groupId, &$responseCode, array &$responseHeaders)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getGroups(
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

        return $groups;
    }

    /**
     * {@inheritdoc}
     */
    public function updateGroupById(string $groupId, GroupInput $groupInput = null, &$responseCode, array &$responseHeaders)
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

        return $groupToUpdate;
    }
}
