<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use OpenAPI\Server\Api\MembersApiInterface;

use OpenAPI\Server\Model\InlineObject;
use OpenAPI\Server\Model\InlineObject1;
use OpenAPI\Server\Model\Member;
use OpenAPI\Server\Model\Members;

use App\Entity;

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
    }

    /**
     * {@inheritdoc}
     */
    public function deleteMemberById($memberId, &$responseCode, array &$responseHeaders)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function deleteMembersMemberIdSection($memberId, &$responseCode, array &$responseHeaders)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getMemberById($memberId, &$responseCode, array &$responseHeaders)
    {
    }

    /**
     * {@inheritdoc}
     */

    public function getMemberLocalMarkerSuggestionsById($memberId, &$responseCode, array &$responseHeaders)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getMembers(&$responseCode, array &$responseHeaders)
    {
        // Add db magic

        return new Members();
    }

    /**
     * {@inheritdoc}
     */
    public function mergeMember($memberId, $mergeMemberId, &$responseCode, array &$responseHeaders)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function putMembersMemberIdGroup($memberId, InlineObject1 $inlineObject1 = null, &$responseCode, array &$responseHeaders)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function putMembersMemberIdSection($memberId, InlineObject $inlineObject = null, &$responseCode, array &$responseHeaders)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function removeMemberLocalMarkerById($memberId, &$responseCode, array &$responseHeaders)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function updateMemberById($memberId, Member $member = null, &$responseCode, array &$responseHeaders)
    {
    }
}
