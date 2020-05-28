<?php
/**
 * RolesApiInterface
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
use OpenAPI\Server\Model\MemberData;
use OpenAPI\Server\Model\RoleData;
use OpenAPI\Server\Model\RoleInput;

/**
 * RolesApiInterface Interface Doc Comment
 *
 * @category Interface
 * @package  OpenAPI\Server\Api
 * @author   OpenAPI Generator team
 * @link     https://github.com/openapitools/openapi-generator
 */
interface RolesApiInterface
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
     * Operation createCustomRole
     *
     * @param  OpenAPI\Server\Model\RoleInput $roleInput   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\RoleData
     *
     */
    public function createCustomRole(RoleInput $roleInput = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation deleteCustomRoleById
     *
     * @param  string $customRoleId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ApiResponse
     *
     */
    public function deleteCustomRoleById(string $customRoleId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getCustomRoleById
     *
     * Your GET endpoint
     *
     * @param  string $customRoleId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\RoleData
     *
     */
    public function getCustomRoleById(string $customRoleId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getCustomRoleMembersById
     *
     * Your GET endpoint
     *
     * @param  string $customRoleId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\MemberData[]
     *
     */
    public function getCustomRoleMembersById(string $customRoleId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getCustomRoles
     *
     * Your GET endpoint
     *
     * @param  string $sort   (optional)
     * @param  int $pageSize   (optional)
     * @param  int $page   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\RoleData[]
     *
     */
    public function getCustomRoles(string $sort = null, int $pageSize = null, int $page = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation updateCustomRoleById
     *
     * @param  string $customRoleId   (required)
     * @param  OpenAPI\Server\Model\RoleInput $roleInput   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\RoleData
     *
     */
    public function updateCustomRoleById(string $customRoleId, RoleInput $roleInput = null, &$responseCode, array &$responseHeaders);
}
