<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Validator\Validator\ValidatorInterface;

use Doctrine\ORM\ORMException;

use OpenAPI\Server\Api\ListsApiInterface;

use App\Entity\EmailList;
use App\Entity\EmailListRecipient;
use App\Entity\EmailListRule;
use App\Entity\Member;
use App\Entity\Role;
use App\Entity\ScoutGroup;
use App\Entity\Section;
use OpenAPI\Server\Model\ApiResponse;
use OpenAPI\Server\Model\ListInput;
use OpenAPI\Server\Model\ListRuleInput;

use App\Exception\SortKeyNotFound;
use Exception;
use Doctrine\ORM\Query\Expr\Join;


class ListsController extends AbstractController implements ListsApiInterface
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
    public function createList(ListInput $listInput = null, &$responseCode, array &$responseHeaders)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $emailAddress = $listInput->getAddress();
        $emailList = $this->getDoctrine()
            ->getRepository(EmailList::class)
            ->findBy(['address' => $emailAddress]);

        if ($emailList) {
            $responseCode = 500;
            return new ApiResponse([
                'code' => 500,
                'type' => 'Address not Unique',
                'message' => "Email List address (${emailAddress}) already exists and can not be created again"
            ]);
        }

        $newEmailList = new EmailList();

        $newEmailList->setName($listInput->getName());
        $newEmailList->setAddress($listInput->getAddress());

        $entityManager->persist($newEmailList);
        $entityManager->flush();

        return [
            'success' => true,
            'list' => $newEmailList->toListData(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function createListRuleByListId(int $listId, ListRuleInput $listRule = null, &$responseCode, array &$responseHeaders)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $emailList = $this->getDoctrine()
            ->getRepository(EmailList::class)
            ->find($listId);

        if (!$emailList) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Email List address (${listId}) does not exist"
            ]);
        }

        if ($listRule->getContactId()) {
            $repo = $this->getDoctrine()->getRepository(Contact::class);
            $entityType = 'Contact';
            $entityId = $listRule->getContactId();
        } else if ($listRule->getMemberId()) {
            $repo = $this->getDoctrine()->getRepository(Member::class);
            $entityType = 'Member';
            $entityId = $listRule->getMemberId();
        } else if ($listRule->getRoleId()) {
            $repo = $this->getDoctrine()->getRepository(Role::class);
            $entityType = 'Role';
            $entityId = $listRule->getRoleId();
        } else if ($listRule->getSectionId()) {
            $repo = $this->getDoctrine()->getRepository(Section::class);
            $entityType = 'Section';
            $entityId = $listRule->getSectionId();
        } else if ($listRule->getScoutGroupId()) {
            $repo = $this->getDoctrine()->getRepository(ScoutGroup::class);
            $entityType = 'ScoutGroup';
            $entityId = $listRule->getScoutGroupId();
        } else {
            $responseCode = 400;
            return new ApiResponse([
                'code' => 400,
                'type' => 'Bad Request',
                'message' => "No relation provided"
            ]);
        }

        $entity = $repo->find($entityId);

        if (!$entity) {
            $responseCode = 400;
            return new ApiResponse([
                'code' => 400,
                'type' => 'Bad Request',
                'message' => "${entityType} (${entityId}) does not exist. Failed to create list rule with invalid relation"
            ]);
        }

        $newEmailListMem = new EmailListRule();

        $newEmailListMem->setEmailList($emailList);

        $newEmailListMem->setLabel($listRule->getLabel());
        $newEmailListMem->setComment($listRule->getComment());

        $newEmailListMem->setUseMember($listRule->isUseMember());
        $newEmailListMem->setUseContact($listRule->isUseContact());

        switch ($entityType) {
            case 'Contact':
                $newEmailListMem->setContact($entity);
                break;
            case 'Member':
                $newEmailListMem->setMember($entity);
                break;
            case 'Role':
                $newEmailListMem->setRole($entity);
                break;
            case 'Section':
                $newEmailListMem->setSection($entity);
                break;
            case 'ScoutGroup':
                $newEmailListMem->setScoutGroup($entity);
                break;
        }

        $entityManager->persist($newEmailListMem);
        $entityManager->flush();

        return [
            'success' => true,
            'listRule' => $newEmailListMem->toListRuleData(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function deleteListById(int $listId, &$responseCode, array &$responseHeaders)
    {
        $emailList = $this->getDoctrine()
            ->getRepository(EmailList::class)
            ->find($listId);

        if (!$emailList) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "List (${listId}) not found"
            ]);
        }

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($emailList);
        $entityManager->flush();

        return new ApiResponse([
            'code' => 200,
            'type' => 'List Deleted',
            'message' => "List (${listId}) was deleted"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteListRuleByListId(int $listId, int $ruleId, &$responseCode, array &$responseHeaders)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $emailList = $this->getDoctrine()
            ->getRepository(EmailList::class)
            ->find($listId);

        if (!$emailList) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Email List (${listId}) does not exist"
            ]);
        }

        $emailListRule = $this->getDoctrine()
            ->getRepository(EmailListRule::class)
            ->find($ruleId);

        if (!$emailListRule) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Email List Rule (${ruleId}) not found"
            ]);
        }

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($emailListRule);
        $entityManager->flush();

        return new ApiResponse([
            'code' => 200,
            'type' => 'List Rule Deleted',
            'message' => "List Rule (${ruleId}) was deleted"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getListById(int $listId, &$responseCode, array &$responseHeaders)
    {
        $emailList = $this->getDoctrine()
            ->getRepository(EmailList::class)
            ->find($listId);

        if (!$emailList) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "List (${listId}) not found"
            ]);
        }

        return [
            'success' => true,
            'list' => $emailList->toListData(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getListByAddress(string $listAddress, &$responseCode, array &$responseHeaders)
    {
        try {
            $emailList = $this->getDoctrine()
                ->getRepository(EmailList::class)
                ->findOneBy(['address' => $listAddress]);
        } catch (Exception $e) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 401,
                'type' => 'Multiple Lists found',
                'message' => "Multiple lists found for (${listAddress})"
            ]);
        }

        if (!$emailList) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "List (${listAddress}) not found"
            ]);
        }

        return [
            'success' => true,
            'list' => $emailList->toListData(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getListRecipientsByListId(int $listId, string $query = null, string $sort = null, int $pageSize = null, int $page = null, &$responseCode, array &$responseHeaders)
    {
        /** @var EmailList */
        $emailList = $this->getDoctrine()
            ->getRepository(EmailList::class)
            ->find($listId);

        if (!$emailList) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "List (${listId}) not found"
            ]);
        }
        /** @var MemberRepository */
        $memberRepo = $this->getDoctrine()->getRepository(Member::class);
        /** @var ContactRepository */
        $contactRepo = $this->getDoctrine()->getRepository(Contact::class);
        /** @var EmailListRecipientRepository */
        $emailListRecipientRepo = $this->getDoctrine()->getRepository(EmailListRecipient::class);

        $memberToRule = [];
        $contactToRule = [];
        function addMemberById(&$memberToRule, int $memberId, EmailListRule $rule)
        {
            if ($rule->getUseMember()) {
                $memberToRule[$memberId][] = $rule->getId();
            }
        }
        function addContactFromMember(&$contactToRule, Member $member, EmailListRule $rule)
        {
            if ($rule->getUseContact()) {
                foreach ($member->getContacts() as $i => $contact) {
                    $contactToRule[$contact->getId()][] = $rule->getId();
                }
            }
        }
        function addContactById(&$contactToRule, int $contactId, EmailListRule $rule)
        {
            if ($rule->getUseContact()) {
                $contactToRule[$contactId][] = $rule->getId();
            }
        }

        $rules = $emailList->getEmailListRules();
        foreach ($rules as $i => $rule) {

            if ($member = $rule->getMember()) {
                addMemberById($memberToRule, $member->getId(), $rule);
                addContactFromMember($contactToRule, $member, $rule);
            } else if ($contact = $rule->getContact()) {
                addContactById($contactToRule, $contact->getId(), $rule);
            } else if ($role = $rule->getRole()) {

                // Get members of this role.
                $qb = $memberRepo->createQueryBuilder('m');
                $qb->select('m.id');
                $qb->join('m.roles', 'mr', Join::WITH, $qb->expr()->eq('mr.role', ':role'));
                $qb->setParameter('role', $role->getId());
                $result = $qb->getQuery()->getScalarResult();

                foreach ($result as $i => $memberId) {
                    addMemberById($memberToRule, $memberId['id'], $rule);
                }

                // Get contacts of this role.
                $qb = $contactRepo->createQueryBuilder('c');
                $qb->select('c.id');
                $qb->join('c.member', 'm');
                $qb->join('m.roles', 'mr', Join::WITH, $qb->expr()->eq('mr.role', ':role'));
                $qb->setParameter('role', $role->getId());
                $result = $qb->getQuery()->getScalarResult();

                foreach ($result as $i => $contactId) {
                    addContactById($contactToRule, $contactId['id'], $rule);
                }
            } else if ($section = $rule->getSection()) {
                // Get members of this section.
                $qb = $memberRepo->createQueryBuilder('m');
                $qb->select('m.id');
                $qb->join('m.roles', 'mr');
                $qb->join('mr.role', 'r', Join::WITH, $qb->expr()->eq('r.section', ':section'));
                $qb->setParameter('section', $section->getId());                // echo 'here2';

                $result = $qb->getQuery()->getScalarResult();
                foreach ($result as $i => $memberId) {
                    addMemberById($memberToRule, $memberId['id'], $rule);
                }

                // Get contacts of this section.
                $qb = $contactRepo->createQueryBuilder('c');
                $qb->select('c.id');
                $qb->join('c.member', 'm');
                $qb->join('m.roles', 'mr');
                $qb->join('mr.role', 'r', Join::WITH, $qb->expr()->eq('r.section', ':section'));
                $qb->setParameter('section', $section->getId());

                $result = $qb->getQuery()->getScalarResult();
                foreach ($result as $i => $contactId) {
                    addContactById($contactToRule, $contactId['id'], $rule);
                }
            } else if ($scoutGroup = $rule->getScoutGroup()) {

                // Get members of this scout group.
                $qb = $memberRepo->createQueryBuilder('m');
                $qb->select('m.id');
                $qb->join('m.roles', 'mr');
                $qb->join('mr.role', 'r');
                $qb->join('r.section', 's', Join::WITH, $qb->expr()->eq('s.scoutGroup', ':scoutGroup'));
                $qb->setParameter('scoutGroup', $scoutGroup->getId());

                $result = $qb->getQuery()->getScalarResult();
                foreach ($result as $i => $memberId) {
                    addMemberById($memberToRule, $memberId['id'], $rule);
                }

                // Get contacts of this scout group.
                $qb = $contactRepo->createQueryBuilder('c');
                $qb->select('c.id');
                $qb->join('c.member', 'm');
                $qb->join('m.roles', 'mr');
                $qb->join('mr.role', 'r');
                $qb->join('r.section', 's', Join::WITH, $qb->expr()->eq('s.scoutGroup', ':scoutGroup'));
                $qb->setParameter('scoutGroup', $scoutGroup->getId());

                $result = $qb->getQuery()->getScalarResult();
                foreach ($result as $i => $contactId) {
                    addContactById($contactToRule, $contactId['id'], $rule);
                }
            } else {
                // Intentionally left empty.
            }
        }

        $memberIds = array_keys($memberToRule);
        $contactIds = array_keys($contactToRule);

        $qb = $emailListRecipientRepo->createQueryBuilder('e')->select('e');
        $qb->where(
            $qb->expr()->orX(
                $qb->expr()->andX(
                    $qb->expr()->in('e.id', ':memberIds'),
                    $qb->expr()->eq('e.type', ':memberType')
                ),
                $qb->expr()->andX(
                    $qb->expr()->in('e.id', ':contactIds'),
                    $qb->expr()->eq('e.type', ':contactType')
                )
            )
        );
        $qb->setParameter('memberIds', $memberIds);
        $qb->setParameter('memberType', 'member');
        $qb->setParameter('contactIds', $contactIds);
        $qb->setParameter('contactType', 'contact');

        $expression = $qb->expr()->orX(
            $qb->expr()->like('e.firstname', ':search'),
            $qb->expr()->like('e.lastname', ':search'),
            $qb->expr()->like('e.membershipNumber', ':search')
        );

        try {
            $result = $emailListRecipientRepo->pageFetcherHelper(
                $expression,
                function (EmailListRecipient $recipient) use ($emailList, $memberToRule, $contactToRule) {
                    if ($recipient->getType() === 'member') {
                        $contributingRuleIds = $memberToRule[$recipient->getId()];
                    } else if ($recipient->getType() === 'contact') {
                        $contributingRuleIds = $contactToRule[$recipient->getId()];
                    } else {
                        $contributingRuleIds = [];
                    }

                    return $recipient->toListRecipientData($emailList, $contributingRuleIds);
                },
                'recipients',
                "%${query}%",
                $sort,
                $pageSize,
                $page,
                'id',
                $qb
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
    public function getListRuleByListId(int $listId, int $ruleId, &$responseCode, array &$responseHeaders)
    {
        /** @var EmailListRule */
        $emailListMem = $this->getDoctrine()
            ->getRepository(EmailListRule::class)
            ->find($listId);

        if (!$emailListMem) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "List Rule (${ruleId}) not found"
            ]);
        }

        if ($emailListMem->getEmailList()->getId() !== $listId) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "List Rule (${ruleId}) not found for List (${listId})"
            ]);
        }

        return [
            'success' => true,
            'listRule' => $emailListMem->toListRuleData(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getListRulesByListId(int $listId, string $query = null, string $sort = null, int $pageSize = null, int $page = null, &$responseCode, array &$responseHeaders)
    {
        /** @var EmailListRuleRepository */
        $repo = $this->getDoctrine()->getRepository(EmailListRule::class);

        try {
            $result = $repo->findByPage(
                $query,
                $sort,
                $pageSize,
                $page,
                ['listId' => $listId]
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
    public function getLists(string $query = null, string $sort = null, int $pageSize = null, int $page = null, &$responseCode, array &$responseHeaders)
    {
        /** @var EmailListRepository */
        $repo = $this->getDoctrine()->getRepository(EmailList::class);

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
    public function updateListById(int $listId, ListInput $listInput = null, &$responseCode, array &$responseHeaders)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $emailListToUpdate = $this->getDoctrine()
            ->getRepository(EmailList::class)
            ->find($listId);

        if (!$emailListToUpdate) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Email List (${listId}) not found"
            ]);
        }

        $emailAddress = $listInput->getAddress();
        $emailList = $this->getDoctrine()
            ->getRepository(EmailList::class)
            ->findBy(['address' => $emailAddress]);

        if ($emailList) {
            $responseCode = 500;
            return new ApiResponse([
                'code' => 500,
                'type' => 'Address not Unique',
                'message' => "Email List address (${emailAddress}) already exists and can not be created again"
            ]);
        }

        $emailListToUpdate->setName($listInput->getName());
        $emailListToUpdate->setAddress($listInput->getAddress());

        $entityManager->persist($emailListToUpdate);
        $entityManager->flush();

        return [
            'success' => true,
            'list' => $emailListToUpdate->toListData(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function updateListRuleByListId(int $listId, int $ruleId, ListRuleInput $listRule = null, &$responseCode, array &$responseHeaders)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $emailList = $this->getDoctrine()
            ->getRepository(EmailList::class)
            ->find($listId);

        if ($emailList) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Email List (${listId}) does not exist"
            ]);
        }

        $emailListRuleToUpdate = $this->getDoctrine()
            ->getRepository(EmailListRule::class)
            ->find($ruleId);

        if (!$emailListRuleToUpdate) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Email List Rule (${ruleId}) not found"
            ]);
        }

        if ($listRule->getContactId()) {
            $repo = $this->getDoctrine()->getRepository(Contact::class);
            $entityType = 'Contact';
            $entityId = $listRule->getContactId();
        } else if ($listRule->getMemberId()) {
            $repo = $this->getDoctrine()->getRepository(Member::class);
            $entityType = 'Member';
            $entityId = $listRule->getMemberId();
        } else if ($listRule->getRoleId()) {
            $repo = $this->getDoctrine()->getRepository(Role::class);
            $entityType = 'Role';
            $entityId = $listRule->getRoleId();
        } else if ($listRule->getSectionId()) {
            $repo = $this->getDoctrine()->getRepository(Section::class);
            $entityType = 'Section';
            $entityId = $listRule->getSectionId();
        } else if ($listRule->getScoutGroupId()) {
            $repo = $this->getDoctrine()->getRepository(ScoutGroup::class);
            $entityType = 'ScoutGroup';
            $entityId = $listRule->getScoutGroupId();
        } else {
            $responseCode = 400;
            return new ApiResponse([
                'code' => 400,
                'type' => 'Bad Request',
                'message' => "No relation provided"
            ]);
        }

        $entity = $repo->find($entityId);

        if (!$entity) {
            $responseCode = 400;
            return new ApiResponse([
                'code' => 400,
                'type' => 'Bad Request',
                'message' => "${entityType} (${entityId}) does not exist. Failed to create list rule with invalid relation"
            ]);
        }

        $emailListRuleToUpdate->setLabel($listRule->getLabel());
        $emailListRuleToUpdate->setComment($listRule->getComment());

        $emailListRuleToUpdate->setUseMember($listRule->isUseMember());
        $emailListRuleToUpdate->setUseContact($listRule->isUseContact());
        $emailListRuleToUpdate->setContact(($entityType === 'Contact') ? $entity : null);
        $emailListRuleToUpdate->setMember(($entityType === 'Member') ? $entity : null);
        $emailListRuleToUpdate->setRole(($entityType === 'Role') ? $entity : null);
        $emailListRuleToUpdate->setSection(($entityType === 'Section') ? $entity : null);
        $emailListRuleToUpdate->setScoutGroup(($entityType === 'ScoutGroup') ? $entity : null);

        $entityManager->persist($emailListRuleToUpdate);
        $entityManager->flush();

        return [
            'success' => true,
            'listRule' => $emailListRuleToUpdate->toListRuleData(),
        ];
    }
}
