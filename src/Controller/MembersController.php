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
use OpenAPI\Server\Model\ApiResponse;

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
    public function createMember(MemberInput $member, &$responseCode, array &$responseHeaders)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $newMember = new Member();
        $newMember->setFirstname($member->getFirstname());
        $newMember->setLastname($member->getLastname());
        $newMember->setNickname($member->getNickname());
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
            $members = $this->getDoctrine()
                ->getRepository(Member::class)
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
    public function removeMemberSectionById($memberId, &$responseCode, array &$responseHeaders)
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
    public function setMemberGroupById($memberId, GroupInput $groupInput = null, &$responseCode, array &$responseHeaders)
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
    public function setMemberSectionById($memberId, array $sectionData = null, &$responseCode, array &$responseHeaders)
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
