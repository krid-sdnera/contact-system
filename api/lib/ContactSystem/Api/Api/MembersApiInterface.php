<?php
/**
 * MembersApiInterface
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
use OpenAPI\Server\Model\Contacts;
use OpenAPI\Server\Model\MemberData;
use OpenAPI\Server\Model\MemberInput;
use OpenAPI\Server\Model\MemberRoleData;
use OpenAPI\Server\Model\MemberRoleInput;
use OpenAPI\Server\Model\MemberRoles;
use OpenAPI\Server\Model\Members;

/**
 * MembersApiInterface Interface Doc Comment
 *
 * @category Interface
 * @package  OpenAPI\Server\Api
 * @author   OpenAPI Generator team
 * @link     https://github.com/openapitools/openapi-generator
 */
interface MembersApiInterface
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
     * Operation addMemberRoleById
     *
     * Add Member Role
     *
     * @param  int $memberId   (required)
     * @param  int $roleId   (required)
     * @param  OpenAPI\Server\Model\MemberRoleInput $memberRoleInput   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\MemberRoleData
     *
     */
    public function addMemberRoleById(int $memberId, int $roleId, MemberRoleInput $memberRoleInput = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation createMember
     *
     * Create a member
     *
     * @param  OpenAPI\Server\Model\MemberInput $memberInput   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\MemberData
     *
     */
    public function createMember(MemberInput $memberInput, &$responseCode, array &$responseHeaders);

    /**
     * Operation deleteMemberById
     *
     * Delete member
     *
     * @param  int $memberId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ApiResponse
     *
     */
    public function deleteMemberById(int $memberId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getMemberById
     *
     * Get member
     *
     * @param  int $memberId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\MemberData
     *
     */
    public function getMemberById(int $memberId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getMemberContactsById
     *
     * List member's contacts
     *
     * @param  int $memberId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\Contacts
     *
     */
    public function getMemberContactsById(int $memberId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getMemberRolesById
     *
     * List member's roles
     *
     * @param  int $memberId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\MemberRoles
     *
     */
    public function getMemberRolesById(int $memberId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getMembers
     *
     * List all members
     *
     * @param  string $sort   (optional)
     * @param  int $pageSize   (optional)
     * @param  int $page   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\Members
     *
     */
    public function getMembers(string $sort = null, int $pageSize = null, int $page = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation mergeMember
     *
     * Merge member
     *
     * @param  int $memberId   (required)
     * @param  int $mergeMemberId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ApiResponse
     *
     */
    public function mergeMember(int $memberId, int $mergeMemberId, &$responseCode, array &$responseHeaders);

    /**
     * Operation patchMemberById
     *
     * Partially update member
     *
     * @param  int $memberId   (required)
     * @param  OpenAPI\Server\Model\MemberInput $memberInput   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\MemberData
     *
     */
    public function patchMemberById(int $memberId, MemberInput $memberInput = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation removeMemberRoleById
     *
     * Remove Member Role
     *
     * @param  int $memberId   (required)
     * @param  int $roleId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ApiResponse
     *
     */
    public function removeMemberRoleById(int $memberId, int $roleId, &$responseCode, array &$responseHeaders);

    /**
     * Operation updateMemberById
     *
     * Update member
     *
     * @param  int $memberId   (required)
     * @param  OpenAPI\Server\Model\MemberInput $memberInput   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\MemberData
     *
     */
    public function updateMemberById(int $memberId, MemberInput $memberInput = null, &$responseCode, array &$responseHeaders);
}
