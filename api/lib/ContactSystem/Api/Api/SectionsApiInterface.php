<?php
/**
 * SectionsApiInterface
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
use OpenAPI\Server\Model\SectionData;
use OpenAPI\Server\Model\SectionInput;

/**
 * SectionsApiInterface Interface Doc Comment
 *
 * @category Interface
 * @package  OpenAPI\Server\Api
 * @author   OpenAPI Generator team
 * @link     https://github.com/openapitools/openapi-generator
 */
interface SectionsApiInterface
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
     * Operation addSectionLocalMarkerById
     *
     * @param  string $sectionId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ApiResponse
     *
     */
    public function addSectionLocalMarkerById(string $sectionId, &$responseCode, array &$responseHeaders);

    /**
     * Operation createSection
     *
     * Create Section
     *
     * @param  OpenAPI\Server\Model\SectionInput $sectionInput   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\SectionData
     *
     */
    public function createSection(SectionInput $sectionInput = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation deleteSectionById
     *
     * Delete Section
     *
     * @param  string $sectionId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ApiResponse
     *
     */
    public function deleteSectionById(string $sectionId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getSectionById
     *
     * Get Section
     *
     * @param  string $sectionId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\SectionData
     *
     */
    public function getSectionById(string $sectionId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getSectionMembersById
     *
     * Your GET endpoint
     *
     * @param  string $sectionId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\MemberData[]
     *
     */
    public function getSectionMembersById(string $sectionId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getSections
     *
     * Get Sections
     *
     * @param  string $sort   (optional)
     * @param  int $pageSize   (optional)
     * @param  int $page   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\SectionData[]
     *
     */
    public function getSections(string $sort = null, int $pageSize = null, int $page = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation removeSectionLocalMarkerById
     *
     * @param  string $sectionId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ApiResponse
     *
     */
    public function removeSectionLocalMarkerById(string $sectionId, &$responseCode, array &$responseHeaders);

    /**
     * Operation updateSectionById
     *
     * Update Section
     *
     * @param  string $sectionId   (required)
     * @param  OpenAPI\Server\Model\SectionInput $sectionInput   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\SectionData
     *
     */
    public function updateSectionById(string $sectionId, SectionInput $sectionInput = null, &$responseCode, array &$responseHeaders);
}