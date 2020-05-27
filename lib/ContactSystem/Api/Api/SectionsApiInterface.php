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
use OpenAPI\Server\Model\Section;

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
    public function addSectionLocalMarkerById($sectionId, &$responseCode, array &$responseHeaders);

    /**
     * Operation createSection
     *
     * @param  OpenAPI\Server\Model\Section $section   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\Section
     *
     */
    public function createSection(Section $section = null, &$responseCode, array &$responseHeaders);

    /**
     * Operation deleteSectionById
     *
     * @param  string $sectionId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\ApiResponse
     *
     */
    public function deleteSectionById($sectionId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getSectionById
     *
     * Your GET endpoint
     *
     * @param  string $sectionId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\Section
     *
     */
    public function getSectionById($sectionId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getSectionMembersById
     *
     * Your GET endpoint
     *
     * @param  string $sectionId   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return string[]
     *
     */
    public function getSectionMembersById($sectionId, &$responseCode, array &$responseHeaders);

    /**
     * Operation getSections
     *
     * Your GET endpoint
     *
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\Section[]
     *
     */
    public function getSections(&$responseCode, array &$responseHeaders);

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
    public function removeSectionLocalMarkerById($sectionId, &$responseCode, array &$responseHeaders);

    /**
     * Operation updateSectionById
     *
     * @param  string $sectionId   (required)
     * @param  OpenAPI\Server\Model\Section $section   (optional)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return OpenAPI\Server\Model\Section
     *
     */
    public function updateSectionById($sectionId, Section $section = null, &$responseCode, array &$responseHeaders);
}
