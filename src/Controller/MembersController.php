<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Validator\Validator\ValidatorInterface;

use Doctrine\ORM\ORMException;

use OpenAPI\Server\Api\MembersApiInterface;

use OpenAPI\Server\Model\InlineObject;
use OpenAPI\Server\Model\InlineObject1;
use OpenAPI\Server\Model\Member;
use OpenAPI\Server\Model\Members;

use App\Entity;
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
    public function addMember(Member $member, &$responseCode, array &$responseHeaders)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $product = new Entity\Member();
        $product->setFirstname($member->getFirstname());
        $product->setLastname($member->getLastname());
        $product->setNickname($member->getNickname());
        $product->setAddress((array) $member->getAddress());

        // $errors = $validator->validate($product);
        // if (count($errors) > 0) {
        //     $responseCode = 400;
        //     return (string) $errors;
        // }

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $member->setId($product->getId());
        return $member;
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
    public function deleteMemberById($memberId, &$responseCode, array &$responseHeaders)
    {
        $member = $this->getDoctrine()
            ->getRepository(Entity\Member::class)
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
    public function deleteMembersMemberIdSection($memberId, &$responseCode, array &$responseHeaders)
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
    public function getMemberById($memberId, &$responseCode, array &$responseHeaders)
    {
        $member = $this->getDoctrine()
            ->getRepository(Entity\Member::class)
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
                ->getRepository(Entity\Member::class)
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
    public function putMembersMemberIdGroup($memberId, InlineObject1 $inlineObject1 = null, &$responseCode, array &$responseHeaders)
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
    public function putMembersMemberIdSection($memberId, InlineObject $inlineObject = null, &$responseCode, array &$responseHeaders)
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
    public function updateMemberById($memberId, Member $member = null, &$responseCode, array &$responseHeaders)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $memberToUpdate = $this->getDoctrine()
            ->getRepository(Entity\Member::class)
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
        $memberToUpdate->setAddress(['id' => $member->getAddress()->getId()]);

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
