<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\Validator\Validator\ValidatorInterface;

use Doctrine\ORM\ORMException;

use OpenAPI\Server\Api\ContactsApiInterface;

use OpenAPI\Server\Model\ContactInput;

use App\Entity\Contact;
use App\Entity\Member;
use OpenAPI\Server\Model\ApiResponse;

use App\Exception\SortKeyNotFound;
use DateTime;

class ContactsController extends AbstractController implements ContactsApiInterface
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
    public function createContact(ContactInput $contactInput = null, &$responseCode, array &$responseHeaders)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $memberId = $contactInput->getMemberId();
        $member = $this->getDoctrine()
            ->getRepository(Member::class)
            ->find($memberId);

        if (!$member) {
            $responseCode = 500;
            return new ApiResponse([
                'code' => 500,
                'type' => 'Constraint not met',
                'message' => "Member (${memberId}) required for contact creation and was not found"
            ]);
        }

        $newContact = new Contact();

        $newContact->setManagementState(Contact::DefaultManagementState);
        $newContact->setState(Contact::DefaultState);
        $newContact->setOverrides(Contact::DefaultOverrides);

        $newContact->setFirstname($contactInput->getFirstname());
        $newContact->setLastname($contactInput->getLastname());
        $newContact->setNickname($contactInput->getNickname());
        $newContact->setOccupation($contactInput->getOccupation());
        $newContact->setRelationship($contactInput->getRelationship());
        $newContact->setPhoneHome($contactInput->getPhoneHome());
        $newContact->setPhoneMobile($contactInput->getPhoneMobile());
        $newContact->setPhoneWork($contactInput->getPhoneWork());
        $newContact->setEmail($contactInput->getEmail());
        $newContact->setPrimaryContact($contactInput->isPrimaryContact());
        $newContact->setMember($member);

        $newContact->setAddress([
            'street1' => $contactInput->getAddress()->getStreet1(),
            'street2' => $contactInput->getAddress()->getStreet2(),
            'city' => $contactInput->getAddress()->getCity(),
            'state' => $contactInput->getAddress()->getState(),
            'postcode' => $contactInput->getAddress()->getPostcode(),
        ]);
        $entityManager->persist($newContact);
        $entityManager->flush();

        return $newContact->toContactData();
    }

    /**
     * {@inheritdoc}
     */
    public function deleteContactById(int $contactId, &$responseCode, array &$responseHeaders)
    {
        $contact = $this->getDoctrine()
            ->getRepository(Contact::class)
            ->find($contactId);

        if (!$contact) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Contact (${contactId}) not found"
            ]);
        }

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($contact);
        $entityManager->flush();

        return new ApiResponse([
            'code' => 200,
            'type' => 'Contact Deleted',
            'message' => "Contact (${contactId}) was deleted"
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getContactById(int $contactId, &$responseCode, array &$responseHeaders)
    {
        $contact = $this->getDoctrine()
            ->getRepository(Contact::class)
            ->find($contactId);

        if (!$contact) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Contact (${contactId}) not found"
            ]);
        }

        return $contact->toContactData();
    }

    /**
     * {@inheritdoc}
     */
    public function getContacts(
        $sort = null,
        $pageSize = null,
        $page = null,
        &$responseCode,
        array &$responseHeaders
    ) {
        try {
            $contacts = $this->getDoctrine()
                ->getRepository(Contact::class)
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

        return [
            "contacts" => array_map(
                function ($contact) {
                    return $contact->toContactData();
                },
                $contacts
            )
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function patchContactById($contactId, ContactInput $contact = null, &$responseCode, array &$responseHeaders)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $contactToUpdate = $this->getDoctrine()
            ->getRepository(Contact::class)
            ->find($contactId);

        if (!$contactToUpdate) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Contact (${contactId}) not found"
            ]);
        }

        if ($contact->getMemberId() !== null) {
            $memberId = $contact->getMemberId();
            $member = $this->getDoctrine()
                ->getRepository(Member::class)
                ->find($memberId);

            if (!$member) {
                $responseCode = 500;
                return new ApiResponse([
                    'code' => 500,
                    'type' => 'Constraint not met',
                    'message' => "Member (${memberId}) required for updating and was not found"
                ]);
            }

            $contactToUpdate->setMember($member);
        }

        if ($contact->getState() !== null) {
            $contactToUpdate->setState($contact->getState());
        }

        if ($contact->getOverrides() !== null) {
            $overrides = $contact->getOverrides();
            $contactToUpdate->setOverrides([
                'firstname' => $overrides->isFirstname(),
                'lastname' => $overrides->isLastname(),
                'nickname' => $overrides->isNickname(),
                'address' => $overrides->isAddress(),
                'primaryContact' => $overrides->isPrimaryContact(),
                'email' => $overrides->isEmail(),
                'phoneHome' => $overrides->isPhoneHome(),
                'phoneMobile' => $overrides->isPhoneMobile(),
                'phoneWork' => $overrides->isPhoneWork(),
                'occupation' => $overrides->isOccupation(),
                'relationship' => $overrides->isRelationship(),
            ]);
        }
        // $contactToUpdate->setExpiry(new DateTime($member->getExpiry()));

        if ($contact->getFirstname() !== null) {
            $contactToUpdate->setFirstname($contact->getFirstname());
        }
        if ($contact->getLastname() !== null) {
            $contactToUpdate->setLastname($contact->getLastname());
        }
        if ($contact->getNickname() !== null) {
            $contactToUpdate->setNickname($contact->getNickname());
        }
        if ($contact->getOccupation() !== null) {
            $contactToUpdate->setOccupation($contact->getOccupation());
        }
        if ($contact->getRelationship() !== null) {
            $contactToUpdate->setRelationship($contact->getRelationship());
        }
        if ($contact->getPhoneHome() !== null) {
            $contactToUpdate->setPhoneHome($contact->getPhoneHome());
        }
        if ($contact->getPhoneMobile() !== null) {
            $contactToUpdate->setPhoneMobile($contact->getPhoneMobile());
        }
        if ($contact->getPhoneWork() !== null) {
            $contactToUpdate->setPhoneWork($contact->getPhoneWork());
        }
        if ($contact->getEmail() !== null) {
            $contactToUpdate->setEmail($contact->getEmail());
        }
        if ($contact->isPrimaryContact() !== null) {
            $contactToUpdate->setPrimaryContact($contact->isPrimaryContact());
        }

        if ($contact->getAddress() !== null) {
            $address = $contact->getAddress();

            $contactToUpdate->setAddress([
                'street1' => $address->getStreet1(),
                'street2' => $address->getStreet2(),
                'city' => $address->getCity(),
                'state' => $address->getState(),
                'postcode' => $address->getPostcode(),
            ]);
        }

        $entityManager->persist($contactToUpdate);
        $entityManager->flush();

        return $contactToUpdate->toContactData();
    }

    /**
     * {@inheritdoc}
     */
    public function updateContactById(int $contactId, ContactInput $contactInput = null, &$responseCode, array &$responseHeaders)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $contactToUpdate = $this->getDoctrine()
            ->getRepository(Contact::class)
            ->find($contactId);

        if (!$contactToUpdate) {
            $responseCode = 404;
            return new ApiResponse([
                'code' => 404,
                'type' => 'Not Found',
                'message' => "Contact (${contactId}) not found"
            ]);
        }

        $memberId = $contactInput->getMemberId();
        $member = $this->getDoctrine()
            ->getRepository(Member::class)
            ->find($memberId);

        if (!$member) {
            $responseCode = 500;
            return new ApiResponse([
                'code' => 500,
                'type' => 'Constraint not met',
                'message' => "Member (${memberId}) required for updating and was not found"
            ]);
        }

        $contactToUpdate->setState($contactInput->getState());

        $overrides = $contactToUpdate->getOverrides();
        $contactToUpdate->setOverrides([
            'firstname' => $overrides->isFirstname(),
            'lastname' => $overrides->isLastname(),
            'nickname' => $overrides->isNickname(),
            'address' => $overrides->isAddress(),
            'primaryContact' => $overrides->isPrimaryContact(),
            'email' => $overrides->isEmail(),
            'phoneHome' => $overrides->isPhoneHome(),
            'phoneMobile' => $overrides->isPhoneMobile(),
            'phoneWork' => $overrides->isPhoneWork(),
            'occupation' => $overrides->isOccupation(),
            'relationship' => $overrides->isRelationship(),
        ]);

        // $contactToUpdate->setExpiry(new DateTime($member->getExpiry()));

        $contactToUpdate->setFirstname($contactInput->getFirstname());
        $contactToUpdate->setLastname($contactInput->getLastname());
        $contactToUpdate->setNickname($contactInput->getNickname());
        $contactToUpdate->setOccupation($contactInput->getOccupation());
        $contactToUpdate->setRelationship($contactInput->getRelationship());
        $contactToUpdate->setPhoneHome($contactInput->getPhoneHome());
        $contactToUpdate->setPhoneMobile($contactInput->getPhoneMobile());
        $contactToUpdate->setPhoneWork($contactInput->getPhoneWork());
        $contactToUpdate->setEmail($contactInput->getEmail());
        $contactToUpdate->setPrimaryContact($contactInput->isPrimaryContact());
        $contactToUpdate->setMember($member);

        $contactToUpdate->setAddress([
            'street1' => $contactInput->getAddress()->getStreet1(),
            'street2' => $contactInput->getAddress()->getStreet2(),
            'city' => $contactInput->getAddress()->getCity(),
            'state' => $contactInput->getAddress()->getState(),
            'postcode' => $contactInput->getAddress()->getPostcode(),
        ]);

        $entityManager->persist($contactToUpdate);
        $entityManager->flush();

        return $contactToUpdate->toContactData();
    }
}
