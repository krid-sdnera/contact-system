<?php
/**
 * ScoutGroupsApiInterfaceTest
 * PHP version 7.1.3
 *
 * @category Class
 * @package  OpenAPI\Server\Tests\Api
 * @author   openapi-generator contributors
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
 * Please update the test case below to test the endpoint.
 */

namespace OpenAPI\Server\Tests\Api;

use OpenAPI\Server\Configuration;
use OpenAPI\Server\ApiClient;
use OpenAPI\Server\ApiException;
use OpenAPI\Server\ObjectSerializer;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * ScoutGroupsApiInterfaceTest Class Doc Comment
 *
 * @category Class
 * @package  OpenAPI\Server\Tests\Api
 * @author   openapi-generator contributors
 * @link     https://github.com/openapitools/openapi-generator
 */
class ScoutGroupsApiInterfaceTest extends WebTestCase
{

    /**
     * Setup before running any test cases
     */
    public static function setUpBeforeClass()
    {
    }

    /**
     * Setup before running each test case
     */
    public function setUp()
    {
    }

    /**
     * Clean up after running each test case
     */
    public function tearDown()
    {
    }

    /**
     * Clean up after running all test cases
     */
    public static function tearDownAfterClass()
    {
    }

    /**
     * Test case for createScoutGroup
     *
     * Create Group.
     *
     */
    public function testCreateScoutGroup()
    {
        $client = static::createClient();

        $path = '/groups';

        $crawler = $client->request('POST', $path, [], [], ['CONTENT_TYPE' => 'application/json']);
    }

    /**
     * Test case for deleteScoutGroupById
     *
     * Delete Group.
     *
     */
    public function testDeleteScoutGroupById()
    {
        $client = static::createClient();

        $path = '/groups/{scoutGroupId}';
        $pattern = '{scoutGroupId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('DELETE', $path);
    }

    /**
     * Test case for getListRulesByScoutGroupId
     *
     * Get List Rules By Scout Group ID.
     *
     */
    public function testGetListRulesByScoutGroupId()
    {
        $client = static::createClient();

        $path = '/groups/{scoutGroupId}/list-rules';
        $pattern = '{scoutGroupId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('GET', $path);
    }

    /**
     * Test case for getScoutGroupById
     *
     * Get Group.
     *
     */
    public function testGetScoutGroupById()
    {
        $client = static::createClient();

        $path = '/groups/{scoutGroupId}';
        $pattern = '{scoutGroupId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('GET', $path);
    }

    /**
     * Test case for getScoutGroupSectionsByScoutGroupId
     *
     * Get Scout Group Sections By Scout Group ID.
     *
     */
    public function testGetScoutGroupSectionsByScoutGroupId()
    {
        $client = static::createClient();

        $path = '/groups/{scoutGroupId}/sections';
        $pattern = '{scoutGroupId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('GET', $path);
    }

    /**
     * Test case for getScoutGroups
     *
     * Get Groups.
     *
     */
    public function testGetScoutGroups()
    {
        $client = static::createClient();

        $path = '/groups';

        $crawler = $client->request('GET', $path);
    }

    /**
     * Test case for updateScoutGroupById
     *
     * Update Group.
     *
     */
    public function testUpdateScoutGroupById()
    {
        $client = static::createClient();

        $path = '/groups/{scoutGroupId}';
        $pattern = '{scoutGroupId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('PUT', $path, [], [], ['CONTENT_TYPE' => 'application/json']);
    }

    protected function genTestData($regexp)
    {
        $grammar  = new \Hoa\File\Read('hoa://Library/Regex/Grammar.pp');
        $compiler = \Hoa\Compiler\Llk\Llk::load($grammar);
        $ast      = $compiler->parse($regexp);
        $generator = new \Hoa\Regex\Visitor\Isotropic(new \Hoa\Math\Sampler\Random());

        return $generator->visit($ast); 
    }
}
