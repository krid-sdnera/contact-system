<?php
/**
 * ContactsApiInterface
 * PHP version 5
 *
 * @category Class
 * @package  OpenAPI\Server
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

namespace OpenAPI\Server\Api;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use OpenAPI\Server\Model\ApiResponse;
use OpenAPI\Server\Model\ContactData;
use OpenAPI\Server\Model\ContactInput;
use OpenAPI\Server\Model\Contacts;

/**
 * ContactsApiInterface Interface Doc Comment
 *
 * @category Interface
 * @package  OpenAPI\Server\Api
 * @author   OpenAPI Generator team
 * @link     https://github.com/openapitools/openapi-generator
 */
interface ContactsApiInterface
{

    /**
     * Sets authentication method contact_auth
     *
     * @param string $value Value of the contact_auth authentication method.
     *
     * @return void
     */
    public function setcontact_auth($value);

    /**
     * Operation createContact
     *
     * @param  OpenAPI\Server\Model\ContactInput $contactInput   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ContactData
     *
     */
    public function createContact(ContactInput $contactInput = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation deleteContactById
     *
     * @param  int $contactId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ApiResponse
     *
     */
    public function deleteContactById(int $contactId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getContactById
     *
     * Your GET endpoint
     *
     * @param  int $contactId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ContactData
     *
     */
    public function getContactById(int $contactId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getContacts
     *
     * Your GET endpoint
     *
     * @param  string $sort   (optional)
     * @param  int $pageSize   (optional)
     * @param  int $page   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\Contacts
     *
     */
    public function getContacts(string $sort = null, int $pageSize = null, int $page = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation patchContactById
     *
     * @param  int $contactId   (required)
     * @param  OpenAPI\Server\Model\ContactInput $contactInput   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ContactData
     *
     */
    public function patchContactById(int $contactId, ContactInput $contactInput = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation updateContactById
     *
     * @param  int $contactId   (required)
     * @param  OpenAPI\Server\Model\ContactInput $contactInput   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ContactData
     *
     */
    public function updateContactById(int $contactId, ContactInput $contactInput = null, &$responseCode, array &$responseHeaders);
}
