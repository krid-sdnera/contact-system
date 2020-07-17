<?php
/**
 * GroupsApiInterfaceTest
 * PHP version 5
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
 * GroupsApiInterfaceTest Class Doc Comment
 *
 * @category Class
 * @package  OpenAPI\Server\Tests\Api
 * @author   openapi-generator contributors
 * @link     https://github.com/openapitools/openapi-generator
 */
class GroupsApiInterfaceTest extends WebTestCase
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
     * Test case for addGroupLocalMarkerById
     *
     * .
     *
     */
    public function testAddGroupLocalMarkerById()
    {
        $client = static::createClient();

        $path = '/groups/{groupId}/local';
        $pattern = '{groupId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('PUT', $path);
    }

    /**
     * Test case for createGroup
     *
     * Create Group.
     *
     */
    public function testCreateGroup()
    {
        $client = static::createClient();

        $path = '/groups';

        $crawler = $client->request('POST', $path);
    }

    /**
     * Test case for deleteGroupById
     *
     * Delete Group.
     *
     */
    public function testDeleteGroupById()
    {
        $client = static::createClient();

        $path = '/groups/{groupId}';
        $pattern = '{groupId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('DELETE', $path);
    }

    /**
     * Test case for deleteGroupLocalMarkerById
     *
     * .
     *
     */
    public function testDeleteGroupLocalMarkerById()
    {
        $client = static::createClient();

        $path = '/groups/{groupId}/local';
        $pattern = '{groupId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('DELETE', $path);
    }

    /**
     * Test case for getGroupById
     *
     * Get Group.
     *
     */
    public function testGetGroupById()
    {
        $client = static::createClient();

        $path = '/groups/{groupId}';
        $pattern = '{groupId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('GET', $path);
    }

    /**
     * Test case for getGroupMembersById
     *
     * Your GET endpoint.
     *
     */
    public function testGetGroupMembersById()
    {
        $client = static::createClient();

        $path = '/groups/{groupId}/members';
        $pattern = '{groupId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('GET', $path);
    }

    /**
     * Test case for getGroupSectionsById
     *
     * Your GET endpoint.
     *
     */
    public function testGetGroupSectionsById()
    {
        $client = static::createClient();

        $path = '/groups/{groupId}/sections';
        $pattern = '{groupId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('GET', $path);
    }

    /**
     * Test case for getGroups
     *
     * Get Groups.
     *
     */
    public function testGetGroups()
    {
        $client = static::createClient();

        $path = '/groups';

        $crawler = $client->request('GET', $path);
    }

    /**
     * Test case for updateGroupById
     *
     * Update Group.
     *
     */
    public function testUpdateGroupById()
    {
        $client = static::createClient();

        $path = '/groups/{groupId}';
        $pattern = '{groupId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('PUT', $path);
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
