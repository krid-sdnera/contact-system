<?php
/**
 * ListsApiInterface
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
use OpenAPI\Server\Model\ListData;
use OpenAPI\Server\Model\ListInput;
use OpenAPI\Server\Model\ListRuleData;
use OpenAPI\Server\Model\ListRuleInput;
use OpenAPI\Server\Model\ListRules;
use OpenAPI\Server\Model\Lists;
use OpenAPI\Server\Model\Recipients;

/**
 * ListsApiInterface Interface Doc Comment
 *
 * @category Interface
 * @package  OpenAPI\Server\Api
 * @author   OpenAPI Generator team
 * @link     https://github.com/openapitools/openapi-generator
 */
interface ListsApiInterface
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
     * Sets authentication method jwt_auth
     *
     * @param string $value Value of the jwt_auth authentication method.
     *
     * @return void
     */
    public function setjwt_auth($value);

    /**
     * Operation createList
     *
     * Create List
     *
     * @param  OpenAPI\Server\Model\ListInput $listInput   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ListData
     *
     */
    public function createList(ListInput $listInput = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation createListRuleByListId
     *
     * Create List Rule By List ID
     *
     * @param  int $listId   (required)
     * @param  OpenAPI\Server\Model\ListRuleInput $listRuleInput   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ListRuleData
     *
     */
    public function createListRuleByListId(int $listId, ListRuleInput $listRuleInput = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation deleteListById
     *
     * Delete List By ID
     *
     * @param  int $listId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ApiResponse
     *
     */
    public function deleteListById(int $listId, &$responseCode, array &$responseHeaders);

    /**
     * Operation deleteListRuleByListId
     *
     * Delete List Rule By List ID
     *
     * @param  int $listId   (required)
     * @param  int $ruleId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ApiResponse
     *
     */
    public function deleteListRuleByListId(int $listId, int $ruleId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getListByAddress
     *
     * Get List By Address
     *
     * @param  string $listAddress   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ListData
     *
     */
    public function getListByAddress(string $listAddress, &$responseCode, array &$responseHeaders);

    /**
     * Operation getListById
     *
     * Get List By ID
     *
     * @param  int $listId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ListData
     *
     */
    public function getListById(int $listId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getListRecipientsByListId
     *
     * Get List Recipients By List ID
     *
     * @param  int $listId   (required)
     * @param  string $query   (optional)
     * @param  string $sort   (optional)
     * @param  int $pageSize   (optional)
     * @param  int $page   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\Recipients
     *
     */
    public function getListRecipientsByListId(int $listId, string $query = null, string $sort = null, int $pageSize = null, int $page = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation getListRuleByListId
     *
     * Get List Rule By List ID
     *
     * @param  int $listId   (required)
     * @param  int $ruleId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ListRuleData
     *
     */
    public function getListRuleByListId(int $listId, int $ruleId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getListRulesByListId
     *
     * Get List Rules By List ID
     *
     * @param  int $listId   (required)
     * @param  string $query   (optional)
     * @param  string $sort   (optional)
     * @param  int $pageSize   (optional)
     * @param  int $page   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ListRules
     *
     */
    public function getListRulesByListId(int $listId, string $query = null, string $sort = null, int $pageSize = null, int $page = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation getLists
     *
     * Get Lists
     *
     * @param  string $query   (optional)
     * @param  string $sort   (optional)
     * @param  int $pageSize   (optional)
     * @param  int $page   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\Lists
     *
     */
    public function getLists(string $query = null, string $sort = null, int $pageSize = null, int $page = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation updateListById
     *
     * Update List By ID
     *
     * @param  int $listId   (required)
     * @param  OpenAPI\Server\Model\ListInput $listInput   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ListData
     *
     */
    public function updateListById(int $listId, ListInput $listInput = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation updateListRuleByListId
     *
     * Update List Rule By List ID
     *
     * @param  int $listId   (required)
     * @param  int $ruleId   (required)
     * @param  OpenAPI\Server\Model\ListRuleInput $listRuleInput   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ListRuleData
     *
     */
    public function updateListRuleByListId(int $listId, int $ruleId, ListRuleInput $listRuleInput = null, &$responseCode, array &$responseHeaders);
}
