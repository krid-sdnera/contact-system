<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Validator\Validator\ValidatorInterface;

use Doctrine\ORM\ORMException;

use OpenAPI\Server\Api\MembersApiInterface;

use OpenAPI\Server\Model\MemberInput;
use OpenAPI\Server\Model\MemberData;
use OpenAPI\Server\Model\GroupInput;
use OpenAPI\Server\Model\SectionInput;
use OpenAPI\Server\Model\MemberRoleInput;

use App\Entity\Member;
use App\Entity\Contact;
use App\Entity\EmailListRule;
use App\Entity\MemberRole;
use App\Entity\Role;
use DateTime;
use OpenAPI\Server\Model\ApiResponse;
use App\Exception\SortKeyNotFound;
use App\Repository\EmailListRuleRepository;

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
    public function setjwt_auth($value)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function addMemberRoleById(int $memberId, int $roleId, MemberRoleInput $memberRoleInput = null, &$responseCode, array &$responseHeaders)
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
            ->findOneBy(['role' => $roleId, 'member' => $memberId]);

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

        return [
            'success' => true,
            'memberRole' => $roleRelation->toMemberRoleData(),
        ];
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

        $newMember->setAutoUpgradeEnabled(false);

        // $errors = $validator->validate($product);
        // if (count($errors) > 0) {
        //     $responseCode = 400;
        //     return (string) $errors;
        // }

        $entityManager->persist($newMember);
        $entityManager->flush();

        return [
            'success' => true,
            'member' => $newMember,
        ];
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

        return [
            'success' => true,
            'member' => $member->toMemberData(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getMemberContactsById(
        int $memberId,
        string $sort = null,
        int $pageSize = null,
        int $page = null,
        &$responseCode,
        array &$responseHeaders
    ) {
        /** @var ContactRepository */
        $repo = $this->getDoctrine()->getRepository(Contact::class);

        try {
            /** @var Members */
            $result = $repo->findByMemberIdPage(
                $memberId,
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
    public function getMemberRolesById(
        int $memberId,
        $sort = null,
        $pageSize = null,
        $page = null,
        &$responseCode,
        array &$responseHeaders
    ) {

        /** @var MemberRoleRepository */
        $repo = $this->getDoctrine()->getRepository(MemberRole::class);

        try {
            $result = $repo->findByMemberIdPage(
                $memberId,
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
    public function getMembers(
        $query = null,
        $sort = null,
        $pageSize = null,
        $page = null,
        &$responseCode,
        array &$responseHeaders
    ) {
        // $this->denyAccessUnlessGranted('ROLE_USER');

        /** @var MemberRepository */
        $repo = $this->getDoctrine()->getRepository(Member::class);

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
    public function getListRulesByMemberId(int $memberId, string $query = null, string $sort = null, int $pageSize = null, int $page = null, &$responseCode, array &$responseHeaders)
    {
        /** @var EmailListRuleRepository */
        $repo = $this->getDoctrine()->getRepository(EmailListRule::class);

        try {
            $result = $repo->findByPage(
                $query,
                $sort,
                $pageSize,
                $page,
                ['memberId' => $memberId]
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

        if ($member->getState() !== null) {
            $memberToUpdate->setState($member->getState());
        }

        if ($member->getOverrides() !== null) {
            $overrides = $member->getOverrides();
            $memberToUpdate->setOverrides([
                'firstname' => $overrides->isFirstname(),
                'lastname' => $overrides->isLastname(),
                'nickname' => $overrides->isNickname(),
                'address' => $overrides->isAddress(),
                'dateOfBirth' => $overrides->isDateOfBirth(),
                'email' => $overrides->isEmail(),
                'phoneHome' => $overrides->isPhoneHome(),
                'phoneMobile' => $overrides->isPhoneMobile(),
                'phoneWork' => $overrides->isPhoneWork(),
                'gender' => $overrides->isGender(),
                'schoolName' => $overrides->isSchoolName(),
                'schoolYearLevel' => $overrides->isSchoolYearLevel(),
            ]);
        }
        // $memberToUpdate->setExpiry((empty($member->getExpiry())) ? null : new DateTime($member->getExpiry()));

        if ($member->getFirstname() !== null) {
            $memberToUpdate->setFirstname($member->getFirstname());
        }
        if ($member->getLastname() !== null) {
            $memberToUpdate->setLastname($member->getLastname());
        }
        if ($member->getNickname() !== null) {
            $memberToUpdate->setNickname($member->getNickname());
        }
        if ($member->getDateOfBirth() !== null) {
            $memberToUpdate->setDateOfBirth(new DateTime($member->getDateOfBirth()));
        }
        if ($member->getMembershipNumber() !== null) {
            $memberToUpdate->setMembershipNumber($member->getMembershipNumber());
        }
        if ($member->getPhoneHome() !== null) {
            $memberToUpdate->setPhoneHome($member->getPhoneHome());
        }
        if ($member->getPhoneMobile() !== null) {
            $memberToUpdate->setPhoneMobile($member->getPhoneMobile());
        }
        if ($member->getPhoneWork() !== null) {
            $memberToUpdate->setPhoneWork($member->getPhoneWork());
        }
        if ($member->getGender() !== null) {
            $memberToUpdate->setGender($member->getGender());
        }
        if ($member->getEmail() !== null) {
            $memberToUpdate->setEmail($member->getEmail());
        }
        if ($member->getSchoolName() !== null) {
            $memberToUpdate->setSchoolName($member->getSchoolName());
        }
        if ($member->getSchoolYearLevel() !== null) {
            $memberToUpdate->setSchoolYearLevel($member->getSchoolYearLevel());
        }

        if ($member->getAddress() !== null) {
            $address = $member->getAddress();

            $memberToUpdate->setAddress([
                'street1' => $address->getStreet1(),
                'street2' => $address->getStreet2(),
                'city' => $address->getCity(),
                'state' => $address->getState(),
                'postcode' => $address->getPostcode(),
            ]);
        }

        // $errors = $validator->validate($product);
        // if (count($errors) > 0) {
        //     $responseCode = 400;
        //     return (string) $errors;
        // }

        $entityManager->persist($memberToUpdate);
        $entityManager->flush();

        return [
            'success' => true,
            'member' => $memberToUpdate->toMemberData(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function removeMemberRoleById(int $memberId, int $roleId, &$responseCode, array &$responseHeaders)
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

        $overrides = $member->getOverrides();

        $memberToUpdate->setState($member->getState());
        $memberToUpdate->setOverrides([
            'firstname' => $overrides->isFirstname(),
            'lastname' => $overrides->isLastname(),
            'nickname' => $overrides->isNickname(),
            'address' => $overrides->isAddress(),
            'dateOfBirth' => $overrides->isDateOfBirth(),
            'email' => $overrides->isEmail(),
            'phoneHome' => $overrides->isPhoneHome(),
            'phoneMobile' => $overrides->isPhoneMobile(),
            'phoneWork' => $overrides->isPhoneWork(),
            'gender' => $overrides->isGender(),
        ]);
        $memberToUpdate->setExpiry((empty($member->getExpiry())) ? null : new DateTime($member->getExpiry()));

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
        $memberToUpdate->setSchoolName($member->getSchoolName());
        $memberToUpdate->setSchoolYearLevel($member->getSchoolYearLevel());

        $address = $member->getAddress();

        $memberToUpdate->setAddress([
            'street1' => $address->getStreet1(),
            'street2' => $address->getStreet2(),
            'city' => $address->getCity(),
            'state' => $address->getState(),
            'postcode' => $address->getPostcode(),
        ]);

        // $errors = $validator->validate($product);
        // if (count($errors) > 0) {
        //     $responseCode = 400;
        //     return (string) $errors;
        // }

        $entityManager->persist($memberToUpdate);
        $entityManager->flush();

        return [
            'success' => true,
            'member' => $memberToUpdate->toMemberData(),
        ];
    }
}
