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
            $roles = $this->getDoctrine()
                ->getRepository(Role::class)
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
