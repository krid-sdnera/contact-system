<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Validator\Validator\ValidatorInterface;

use Doctrine\ORM\ORMException;

use OpenAPI\Server\Api\MembersApiInterface;

use OpenAPI\Server\Model\InlineObject;
use OpenAPI\Server\Model\InlineObject1;
use OpenAPI\Server\Model\MemberInput;
use OpenAPI\Server\Model\MemberData;
use OpenAPI\Server\Model\GroupInput;
use OpenAPI\Server\Model\SectionInput;
use OpenAPI\Server\Model\MemberRoleInput;

use App\Entity\Member;
use App\Entity\MemberRole;
use App\Entity\Role;
use DateTime;
use OpenAPI\Server\Model\ApiResponse;
use App\Exception\SortKeyNotFound;

class MembersController extends AbstractController implements MembersApiInterface
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
    public function addMemberLocalMarkerById($memberId, &$responseCode, array &$responseHeaders)
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
    public function addMemberRoleById(string $memberId, string $roleId, MemberRoleInput $memberRoleInput = null, &$responseCode, array &$responseHeaders)
    {
        $entityManager = $this->getDoctrine()->getManager();

        // Confirm Member exists
        $memberToUpdate = $this->getDoctrine()
            ->getRepository(Member::class)
            ->find($memberId);

        if (!$memberToUpdate) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Member (${memberId}) not found"
            ]);
        }

        // Get relationship if it exisits
        $roleRelation = $this->getDoctrine()
            ->getRepository(MemberRole::class)
            ->findOneBy(['role' => $roleId]);

        // Confirm the role (still)? exists
        $role = $this->getDoctrine()
            ->getRepository(Role::class)
            ->find($roleId);

        if (!$role) {
            if ($roleRelation) {
                // Role does not exist. Somehow a relationship does
                $responseCode = 500;
                return new ApiResponse([
                    'code' => 500,
                    'type' => 'Server Error',
                    'message' => "Role (${roleId}) not found but orphaned relation still exists."
                ]);
            }

            // Role does not exist.
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Role (${roleId}) not found"
            ]);
        }

        if (!$roleRelation) {
            // Set up a new relationship
            $roleRelation = new MemberRole();
            $roleRelation->setManagementState(MemberRole::DefaultManagementState);
            $roleRelation->setState(MemberRole::DefaultState);
            $roleRelation->setRole($role);
            $roleRelation->setMember($memberToUpdate);
            $memberToUpdate->addRole($roleRelation);
        }

        $expiry = ($memberRoleInput->getExpiry()) ? new DateTime($memberRoleInput->getExpiry()) : null;
        $roleRelation->setExpiry($expiry);

        $state = ($memberRoleInput->getState()) ?: MemberRole::DefaultState;
        $roleRelation->setState($state);


        $entityManager->persist($memberToUpdate);
        $entityManager->persist($roleRelation);
        $entityManager->flush();

        return $memberToUpdate;
    }


    /**
     * {@inheritdoc}
     */
    public function createMember(MemberInput $member, &$responseCode, array &$responseHeaders)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $newMember = new Member();

        $newMember->setManagementState(Member::DefaultManagementState);
        $newMember->setState(Member::DefaultState);
        $newMember->setOverrides(Member::DefaultOverrides);

        $newMember->setFirstname($member->getFirstname());
        $newMember->setLastname($member->getLastname());
        $newMember->setNickname($member->getNickname());
        $newMember->setDateOfBirth(new DateTime($member->getDateOfBirth()));
        $newMember->setMembershipNumber($member->getMembershipNumber());
        $newMember->setPhoneHome($member->getPhoneHome());
        $newMember->setPhoneMobile($member->getPhoneMobile());
        $newMember->setPhoneWork($member->getPhoneWork());
        $newMember->setGender($member->getGender());
        $newMember->setEmail($member->getEmail());

        $newMember->setAddress([
            'street1' => $member->getAddress()->getStreet1(),
            'street2' => $member->getAddress()->getStreet2(),
            'city' => $member->getAddress()->getCity(),
            'state' => $member->getAddress()->getState(),
            'postcode' => $member->getAddress()->getPostcode(),
        ]);

        // $errors = $validator->validate($product);
        // if (count($errors) > 0) {
        //     $responseCode = 400;
        //     return (string) $errors;
        // }

        $entityManager->persist($newMember);
        $entityManager->flush();

        return $newMember;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteMemberById($memberId, &$responseCode, array &$responseHeaders)
    {
        $member = $this->getDoctrine()
            ->getRepository(Member::class)
            ->find($memberId);

        if (!$member) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Member (${memberId}) not found"
            ]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($member);
        $entityManager->flush();

        return new ApiResponse([
            'code' => 200,
            'type' => 'Member Deleted',
            'message' => "Member (${memberId}) was deleted"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getMemberById($memberId, &$responseCode, array &$responseHeaders)
    {
        /** @var Member */
        $member = $this->getDoctrine()
            ->getRepository(Member::class)
            ->find($memberId);

        if (!$member) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Member (${memberId}) not found"
            ]);
        }

        return $member->toMemberData();
    }

    /**
     * {@inheritdoc}
     */

    public function getMemberLocalMarkerSuggestionsById($memberId, &$responseCode, array &$responseHeaders)
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
    public function getMembers(
        $sort = null,
        $pageSize = null,
        $page = null,
        &$responseCode,
        array &$responseHeaders
    ) {
        $this->denyAccessUnlessGranted('ROLE_USER');

        try {
            $members = $this->getDoctrine()
                ->getRepository(Member::class)
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

        return array_map(
            function ($member) {
                return $member->toMemberData();
            },
            $members
        );
    }

    /**
     * {@inheritdoc}
     */
    public function mergeMember($memberId, $mergeMemberId, &$responseCode, array &$responseHeaders)
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
    public function patchMemberById($memberId, MemberInput $member = null, &$responseCode, array &$responseHeaders)
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
    public function removeMemberLocalMarkerById($memberId, &$responseCode, array &$responseHeaders)
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
    public function removeMemberRoleById(string $memberId, string $roleId, &$responseCode, array &$responseHeaders)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $memberToUpdate = $this->getDoctrine()
            ->getRepository(Member::class)
            ->find($memberId);

        if (!$memberToUpdate) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Member (${memberId}) not found"
            ]);
        }

        $roleRelationToRemove = $this->getDoctrine()
            ->getRepository(MemberRole::class)
            ->findOneBy(['role' => $roleId]);

        if (!$roleRelationToRemove) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Relationship (Member: ${memberId}, Role: ${roleId}) not found"
            ]);
        }

        $memberToUpdate->removeRole($roleRelationToRemove);

        $entityManager->remove($roleRelationToRemove);
        $entityManager->persist($memberToUpdate);
        $entityManager->flush();

        return new ApiResponse([
            'code' => 200,
            'type' => 'Relationship Deleted',
            'message' => "Relationship (Member: ${memberId}, Role: ${roleId}) was deleted"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function updateMemberById($memberId, MemberInput $member = null, &$responseCode, array &$responseHeaders)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $memberToUpdate = $this->getDoctrine()
            ->getRepository(Member::class)
            ->find($memberId);

        if (!$memberToUpdate) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Member (${memberId}) not found"
            ]);
        }

        $memberToUpdate->setState($member->getState());
        $memberToUpdate->setOverrides((array) $member->getOverrides());
        $memberToUpdate->setExpiry(new DateTime($member->getExpiry()));

        $memberToUpdate->setFirstname($member->getFirstname());
        $memberToUpdate->setLastname($member->getLastname());
        $memberToUpdate->setNickname($member->getNickname());
        $memberToUpdate->setDateOfBirth(new DateTime($member->getDateOfBirth()));
        $memberToUpdate->setMembershipNumber($member->getMembershipNumber());
        $memberToUpdate->setPhoneHome($member->getPhoneHome());
        $memberToUpdate->setPhoneMobile($member->getPhoneMobile());
        $memberToUpdate->setPhoneWork($member->getPhoneWork());
        $memberToUpdate->setGender($member->getGender());
        $memberToUpdate->setEmail($member->getEmail());

        $memberToUpdate->setAddress([
            'street1' => $member->getAddress()->getStreet1(),
            'street2' => $member->getAddress()->getStreet2(),
            'city' => $member->getAddress()->getCity(),
            'state' => $member->getAddress()->getState(),
            'postcode' => $member->getAddress()->getPostcode(),
        ]);

        // $errors = $validator->validate($product);
        // if (count($errors) > 0) {
        //     $responseCode = 400;
        //     return (string) $errors;
        // }

        $entityManager->persist($memberToUpdate);
        $entityManager->flush();

        return $memberToUpdate;
    }
}
