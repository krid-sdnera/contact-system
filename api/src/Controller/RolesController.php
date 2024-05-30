<?php

namespace App\Controller;

use App\Entity\EmailListRule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Validator\Validator\ValidatorInterface;

use Doctrine\ORM\ORMException;

use OpenAPI\Server\Api\RolesApiInterface;

use OpenAPI\Server\Model\RoleInput;

use App\Entity\Member;
use App\Entity\Role;
use App\Entity\Section;
use OpenAPI\Server\Model\ApiResponse;

use App\Exception\SortKeyNotFound;
use App\Repository\EmailListRuleRepository;

class RolesController extends AbstractController implements RolesApiInterface
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
    public function createRole(RoleInput $roleInput = null, &$responseCode, array &$responseHeaders)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $sectionId = $roleInput->getSectionId();
        $section = $this->getDoctrine()
            ->getRepository(Section::class)
            ->find($sectionId);

        if (!$section) {
            $responseCode = 500;
            return new ApiResponse([
                'code' => 500,
                'type' => 'Constraint not met',
                'message' => "Section (${sectionId}) required for role creation and was not found"
            ]);
        }

        $newRole = new Role();
        $newRole->setName($roleInput->getName());
        $newRole->setExternalID($roleInput->getExternalID());
        $newRole->setClassId($roleInput->getClassId());
        $newRole->setNormalisedClassId($roleInput->getNormalisedClassId());
        $newRole->setSection($section);

        $entityManager->persist($newRole);
        $entityManager->flush();

        return [
            'success' => true,
            'role' => $newRole->toRoleData(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function deleteRoleById(int $roleId, &$responseCode, array &$responseHeaders)
    {
        $role = $this->getDoctrine()
            ->getRepository(Role::class)
            ->find($roleId);

        if (!$role) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Role (${roleId}) not found"
            ]);
        }

        $entityManager = $this->getDoctrine()->getManager();

        // TODO: Possible removal of RoleMember relations
        if (count($role->getMembers()) > 0) {
            return new ApiResponse([
                'code' => 500,
                'type' => 'Role has members',
                'message' => "Role (${roleId}) was not deleted because Member records still reference this role."
            ]);
        }

        $entityManager->remove($role);
        $entityManager->flush();

        return new ApiResponse([
            'code' => 200,
            'type' => 'Role Deleted',
            'message' => "Role (${roleId}) was deleted"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getMembersByRoleId(int $roleId, string $query = null, string $sort = null, int $pageSize = null, int $page = null, &$responseCode, array &$responseHeaders)
    {

        /** @var MemberRepository */
        $repo = $this->getDoctrine()->getRepository(Member::class);

        try {
            $result = $repo->findByPage(
                $query,
                $sort,
                $pageSize,
                $page,
                ['roleId' => $roleId]
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
    public function getListRulesByRoleId(int $roleId, string $query = null, string $sort = null, int $pageSize = null, int $page = null, &$responseCode, array &$responseHeaders)
    {
        /** @var EmailListRuleRepository */
        $repo = $this->getDoctrine()->getRepository(EmailListRule::class);

        try {
            $result = $repo->findByPage(
                $query,
                $sort,
                $pageSize,
                $page,
                ['roleId' => $roleId]
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
    public function getRoleById(int $roleId, &$responseCode, array &$responseHeaders)
    {
        $role = $this->getDoctrine()
            ->getRepository(Role::class)
            ->find($roleId);

        if (!$role) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Role (${roleId}) not found"
            ]);
        }

        return [
            'success' => true,
            'role' => $role->toRoleData(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles(
        $query = null,
        $sort = null,
        $pageSize = null,
        $page = null,
        &$responseCode,
        array &$responseHeaders
    ) {

        /** @var RoleRepository */
        $repo = $this->getDoctrine()->getRepository(Role::class);

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
    public function updateRoleById(int $roleId, RoleInput $roleInput = null, &$responseCode, array &$responseHeaders)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $roleToUpdate = $this->getDoctrine()
            ->getRepository(Role::class)
            ->find($roleId);

        if (!$roleToUpdate) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Section (${roleId}) not found"
            ]);
        }

        $sectionId = $roleInput->getSectionId();
        /** @var Section */
        $section = $this->getDoctrine()
            ->getRepository(Section::class)
            ->find($sectionId);

        if (!$section) {
            $responseCode = 500;
            return new ApiResponse([
                'code' => 500,
                'type' => 'Constraint not met',
                'message' => "Section (${sectionId}) required for updating and was not found"
            ]);
        }

        $roleToUpdate->setName($roleInput->getName());
        $roleToUpdate->setSection($section);

        $entityManager->persist($roleToUpdate);
        $entityManager->flush();

        return [
            'success' => true,
            'role' => $roleToUpdate->toRoleData(),
        ];
    }
}
