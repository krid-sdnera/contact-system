<?php
/**
 * ParentsApiInterface
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
use OpenAPI\Server\Model\GroupData;
use OpenAPI\Server\Model\GroupInput;
use OpenAPI\Server\Model\MemberData;
use OpenAPI\Server\Model\MemberParentData;
use OpenAPI\Server\Model\MemberParentInput;

/**
 * ParentsApiInterface Interface Doc Comment
 *
 * @category Interface
 * @package  OpenAPI\Server\Api
 * @author   OpenAPI Generator team
 * @link     https://github.com/openapitools/openapi-generator
 */
interface ParentsApiInterface
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
     * Operation createParent
     *
     * @param  OpenAPI\Server\Model\MemberParentInput $memberParentInput   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\MemberParentData
     *
     */
    public function createParent(MemberParentInput $memberParentInput = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation deleteGroupById
     *
     * @param  string $groupId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ApiResponse
     *
     */
    public function deleteGroupById(string $groupId, &$responseCode, array &$responseHeaders);

    /**
     * Operation deleteParentById
     *
     * @param  string $parentId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ApiResponse
     *
     */
    public function deleteParentById(string $parentId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getGroupById
     *
     * Your GET endpoint
     *
     * @param  string $groupId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\GroupData
     *
     */
    public function getGroupById(string $groupId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getParentById
     *
     * Your GET endpoint
     *
     * @param  string $parentId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\MemberParentData
     *
     */
    public function getParentById(string $parentId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getParentMembersById
     *
     * Your GET endpoint
     *
     * @param  string $parentId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\MemberData[]
     *
     */
    public function getParentMembersById(string $parentId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getParents
     *
     * Your GET endpoint
     *
     * @param  string $sort   (optional)
     * @param  int $pageSize   (optional)
     * @param  int $page   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\MemberParentData[]
     *
     */
    public function getParents(string $sort = null, int $pageSize = null, int $page = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation updateGroupById
     *
     * @param  string $groupId   (required)
     * @param  OpenAPI\Server\Model\GroupInput $groupInput   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\GroupData
     *
     */
    public function updateGroupById(string $groupId, GroupInput $groupInput = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation updateParentById
     *
     * @param  string $parentId   (required)
     * @param  OpenAPI\Server\Model\MemberParentInput $memberParentInput   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\MemberParentData
     *
     */
    public function updateParentById(string $parentId, MemberParentInput $memberParentInput = null, &$responseCode, array &$responseHeaders);
}
