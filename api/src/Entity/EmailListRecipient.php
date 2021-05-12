<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use OpenAPI\Server\Model\RecipientData;

/*
CREATE OR REPLACE ALGORITHM = UNDEFINED DEFINER = root@localhost SQL SECURITY DEFINER VIEW `view_email_recipient` AS
SELECT
  CONCAT('member', member.id) AS row_id,
  member.id AS id,
  member.firstname AS firstname,
  member.nickname AS nickname,
  member.lastname AS lastname,
  member.email AS email,
  'member' AS type
FROM member
UNION
SELECT
  CONCAT('contact', contact.id) AS row_id,
  contact.id AS id,
  contact.firstname AS firstname,
  contact.nickname AS nickname,
  contact.lastname AS lastname,
  contact.email AS email,
  'contact' AS type
FROM contact

DROP VIEW view_email_recipient;
CREATE VIEW view_email_recipient AS SELECT 'member' || member.id AS row_id, member.id AS id, member.firstname AS firstname, member.nickname AS nickname, member.lastname AS lastname, member.email AS email, 'member' AS type FROM member UNION SELECT 'contact' || contact.id AS row_id, contact.id AS id, contact.firstname AS firstname, contact.nickname AS nickname, contact.lastname AS lastname, contact.email AS email, 'contact' AS type FROM contact 
CREATE VIEW view_email_recipient AS SELECT CONCAT('member', member.id) AS row_id, member.id AS id, member.firstname AS firstname, member.nickname AS nickname, member.lastname AS lastname, member.email AS email, 'member' AS type FROM member UNION SELECT CONCAT('contact', contact.id) AS row_id, contact.id AS id, contact.firstname AS firstname, contact.nickname AS nickname, contact.lastname AS lastname, contact.email AS email, 'contact' AS type FROM contact 
*/

/**
 * @ORM\Entity(readOnly=true, repositoryClass="App\Repository\EmailListRecipientRepository")
 * @ORM\Table(name="view_email_recipient")
 */
class EmailListRecipient
{

    public function toListRecipientData(EmailList $emailList, array $contributingRuleIds): RecipientData
    {
        $arrayData = [
            'rowId' => $this->getRowId(),
            'type' => $this->getType(),
            'id' => $this->getId(),
            'address' => $this->getEmail(),
            'name' => $this->getFirstname() . ' ' . $this->getLastname(),
            'listId' => $emailList->getId(),
            'listName' => $emailList->getName(),
            'listAddress' => $emailList->getAddress(),
            'contributingRuleIds' => $contributingRuleIds
        ];

        $data = new RecipientData($arrayData);

        return $data;
    }

    /**
     * @ORM\Id()
     * @ORM\Column(type="string")
     */
    private $rowId;

    /**
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nickname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    public function getRowId(): ?string
    {
        return $this->rowId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
}
