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
use OpenAPI\Server\Model\ListRule;
use OpenAPI\Server\Model\ListType;
use OpenAPI\Server\Model\MemberData;
use OpenAPI\Server\Model\ModelList;

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
     * @param  OpenAPI\Server\Model\ModelList $modelList   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ModelList
     *
     */
    public function createList(ModelList $modelList = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation createListRuleById
     *
     * @param  int $listId   (required)
     * @param  OpenAPI\Server\Model\ListRule $listRule   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ListRule
     *
     */
    public function createListRuleById(int $listId, ListRule $listRule = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation createListTypes
     *
     * @param  OpenAPI\Server\Model\ListType $listType   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ListType
     *
     */
    public function createListTypes(ListType $listType = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation deleteListById
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
     * Operation deleteListRuleById
     *
     * @param  int $listId   (required)
     * @param  int $ruleId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ApiResponse
     *
     */
    public function deleteListRuleById(int $listId, int $ruleId, &$responseCode, array &$responseHeaders);

    /**
     * Operation deleteListTypeById
     *
     * @param  int $listTypeId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ApiResponse
     *
     */
    public function deleteListTypeById(int $listTypeId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getListById
     *
     * Your GET endpoint
     *
     * @param  int $listId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ModelList
     *
     */
    public function getListById(int $listId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getListMembersById
     *
     * Your GET endpoint
     *
     * @param  int $listId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\MemberData[]
     *
     */
    public function getListMembersById(int $listId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getListRuleById
     *
     * Your GET endpoint
     *
     * @param  int $listId   (required)
     * @param  int $ruleId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ListRule
     *
     */
    public function getListRuleById(int $listId, int $ruleId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getListRulesById
     *
     * Your GET endpoint
     *
     * @param  int $listId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ListRule[]
     *
     */
    public function getListRulesById(int $listId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getListTypeById
     *
     * Your GET endpoint
     *
     * @param  int $listTypeId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ListType
     *
     */
    public function getListTypeById(int $listTypeId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getListTypes
     *
     * Your GET endpoint
     *
     * @param  string $sort   (optional)
     * @param  int $pageSize   (optional)
     * @param  int $page   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ListType[]
     *
     */
    public function getListTypes(string $sort = null, int $pageSize = null, int $page = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation getLists
     *
     * Your GET endpoint
     *
     * @param  string $sort   (optional)
     * @param  int $pageSize   (optional)
     * @param  int $page   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ModelList[]
     *
     */
    public function getLists(string $sort = null, int $pageSize = null, int $page = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation updateListById
     *
     * @param  int $listId   (required)
     * @param  OpenAPI\Server\Model\ModelList $modelList   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ModelList
     *
     */
    public function updateListById(int $listId, ModelList $modelList = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation updateListRuleById
     *
     * @param  int $listId   (required)
     * @param  int $ruleId   (required)
     * @param  OpenAPI\Server\Model\ListRule $listRule   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ListRule
     *
     */
    public function updateListRuleById(int $listId, int $ruleId, ListRule $listRule = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation updateListTypeById
     *
     * @param  int $listTypeId   (required)
     * @param  OpenAPI\Server\Model\ListType $listType   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ListType
     *
     */
    public function updateListTypeById(int $listTypeId, ListType $listType = null, &$responseCode, array &$responseHeaders);
}
