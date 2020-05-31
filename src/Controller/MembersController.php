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

use App\Entity\Member;
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
    public function addMemberRoleById(string $memberId, string $roleId, &$responseCode, array &$responseHeaders)
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

        $roleToAdd = $this->getDoctrine()
            ->getRepository(Role::class)
            ->find($roleId);

        if (!$roleToAdd) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Role (${roleId}) not found"
            ]);
        }

        $memberToUpdate->addRole($roleToAdd);

        $entityManager->persist($memberToUpdate);
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

        return $member;
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

        return $members;
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

        $roleToAdd = $this->getDoctrine()
            ->getRepository(Role::class)
            ->find($roleId);

        if (!$roleToAdd) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Role (${roleId}) not found"
            ]);
        }

        $memberToUpdate->removeRole($roleToAdd);

        $entityManager->persist($memberToUpdate);
        $entityManager->flush();

        return $memberToUpdate;
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

        $memberToUpdate->setFirstname($member->getFirstname());
        $memberToUpdate->setLastname($member->getLastname());
        $memberToUpdate->setNickname($member->getNickname());
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
