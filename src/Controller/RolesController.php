<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Validator\Validator\ValidatorInterface;

use Doctrine\ORM\ORMException;

use OpenAPI\Server\Api\RolesApiInterface;

use OpenAPI\Server\Model\RoleInput;

use App\Entity\Role;
use App\Entity\Section;
use OpenAPI\Server\Model\ApiResponse;

use App\Exception\SortKeyNotFound;

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
        $newRole->setSection($section);

        $entityManager->persist($newRole);
        $entityManager->flush();

        return $newRole;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteRoleById(string $roleId, &$responseCode, array &$responseHeaders)
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
    public function getRoleById(string $roleId, &$responseCode, array &$responseHeaders)
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

        return $role;
    }


    /**
     * {@inheritdoc}
     */
    public function getRoleMembersById(string $roleId, string $sort = null, int $pageSize = null, int $page = null, &$responseCode, array &$responseHeaders)
    {
        /** @var Role */
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

        return $role->getMembers();
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles(
        $sort = null,
        $pageSize = null,
        $page = null,
        &$responseCode,
        array &$responseHeaders
    ) {
        try {
            $roles = $this->getDoctrine()
                ->getRepository(Role::class)
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

        return $roles;
    }

    /**
     * {@inheritdoc}
     */
    public function updateRoleById(string $roleId, RoleInput $roleInput = null, &$responseCode, array &$responseHeaders)
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

        return $roleToUpdate;
    }
}
