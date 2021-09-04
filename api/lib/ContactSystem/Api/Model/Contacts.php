<?php
/**
 * Contacts
 *
 * PHP version 7.1.3
 *
 * @category Class
 * @package  OpenAPI\Server\Model
 * @author   OpenAPI Generator team
 * @link     https://github.com/openapitools/openapi-generator
 */

/**
 * Contact System API
 *
 * This is the spec for the Constact system API
 *
 * The version of the OpenAPI document: 1.0.0
 * Contact: dirk@arends.com.au
 * Generated by: https://github.com/openapitools/openapi-generator.git
 *
 */

/**
 * NOTE: This class is auto generated by the openapi generator program.
 * https://github.com/openapitools/openapi-generator
 * Do not edit the class manually.
 */

namespace OpenAPI\Server\Model;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;

/**
 * Class representing the Contacts model.
 *
 * A list of contacts
 *
 * @package OpenAPI\Server\Model
 * @author  OpenAPI Generator team
 */
class Contacts 
{
        /**
     * Total number of items
     *
     * @var int
     * @SerializedName("totalItems")
     * @Assert\NotNull()
     * @Assert\Type("int")
     * @Type("int")
     */
    protected $totalItems;

    /**
     * Total number of pages
     *
     * @var int
     * @SerializedName("totalPages")
     * @Assert\NotNull()
     * @Assert\Type("int")
     * @Type("int")
     */
    protected $totalPages;

    /**
     * Current page number
     *
     * @var int
     * @SerializedName("page")
     * @Assert\NotNull()
     * @Assert\Type("int")
     * @Type("int")
     */
    protected $page;

    /**
     * Number of items in this page
     *
     * @var int
     * @SerializedName("pageSize")
     * @Assert\NotNull()
     * @Assert\Type("int")
     * @Type("int")
     */
    protected $pageSize;

    /**
     * Array containg the list
     *
     * @var OpenAPI\Server\Model\ContactData[]
     * @SerializedName("contacts")
     * @Assert\NotNull()
     * @Assert\Valid()
     * @Assert\All({
     *   @Assert\Type("OpenAPI\Server\Model\ContactData")
     * })
     * @Type("array<OpenAPI\Server\Model\ContactData>")
     */
    protected $contacts;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->totalItems = isset($data['totalItems']) ? $data['totalItems'] : null;
        $this->totalPages = isset($data['totalPages']) ? $data['totalPages'] : null;
        $this->page = isset($data['page']) ? $data['page'] : null;
        $this->pageSize = isset($data['pageSize']) ? $data['pageSize'] : null;
        $this->contacts = isset($data['contacts']) ? $data['contacts'] : null;
    }

    /**
     * Gets totalItems.
     *
     * @return int
     */
    public function getTotalItems(): int
    {
        return $this->totalItems;
    }

    /**
     * Sets totalItems.
     *
     * @param int $totalItems  Total number of items
     *
     * @return $this
     */
    public function setTotalItems(int $totalItems)
    {
        $this->totalItems = $totalItems;

        return $this;
    }

    /**
     * Gets totalPages.
     *
     * @return int
     */
    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    /**
     * Sets totalPages.
     *
     * @param int $totalPages  Total number of pages
     *
     * @return $this
     */
    public function setTotalPages(int $totalPages)
    {
        $this->totalPages = $totalPages;

        return $this;
    }

    /**
     * Gets page.
     *
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * Sets page.
     *
     * @param int $page  Current page number
     *
     * @return $this
     */
    public function setPage(int $page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Gets pageSize.
     *
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * Sets pageSize.
     *
     * @param int $pageSize  Number of items in this page
     *
     * @return $this
     */
    public function setPageSize(int $pageSize)
    {
        $this->pageSize = $pageSize;

        return $this;
    }

    /**
     * Gets contacts.
     *
     * @return OpenAPI\Server\Model\ContactData[]
     */
    public function getContacts(): array
    {
        return $this->contacts;
    }

    /**
     * Sets contacts.
     *
     * @param OpenAPI\Server\Model\ContactData[] $contacts  Array containg the list
     *
     * @return $this
     */
    public function setContacts(array $contacts)
    {
        $this->contacts = $contacts;

        return $this;
    }
}


