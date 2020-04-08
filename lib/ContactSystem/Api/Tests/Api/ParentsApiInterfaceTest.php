<?php
/**
 * ParentsApiInterfaceTest
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
 * ParentsApiInterfaceTest Class Doc Comment
 *
 * @category Class
 * @package  OpenAPI\Server\Tests\Api
 * @author   openapi-generator contributors
 * @link     https://github.com/openapitools/openapi-generator
 */
class ParentsApiInterfaceTest extends WebTestCase
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
     * Test case for deleteGroupsGroupId
     *
     * .
     *
     */
    public function testDeleteGroupsGroupId()
    {
        $client = static::createClient();

        $path = '/groups/{groupId}';
        $pattern = '{groupId}';
        $data = $this->genTestData('[a-z0-9]+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('DELETE', $path);
    }

    /**
     * Test case for deleteParentsParentId
     *
     * .
     *
     */
    public function testDeleteParentsParentId()
    {
        $client = static::createClient();

        $path = '/parents/{parentId}';
        $pattern = '{parentId}';
        $data = $this->genTestData('[a-z0-9]+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('DELETE', $path);
    }

    /**
     * Test case for getGroupsGroupId
     *
     * Your GET endpoint.
     *
     */
    public function testGetGroupsGroupId()
    {
        $client = static::createClient();

        $path = '/groups/{groupId}';
        $pattern = '{groupId}';
        $data = $this->genTestData('[a-z0-9]+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('GET', $path);
    }

    /**
     * Test case for getParents
     *
     * Your GET endpoint.
     *
     */
    public function testGetParents()
    {
        $client = static::createClient();

        $path = '/parents';

        $crawler = $client->request('GET', $path);
    }

    /**
     * Test case for getParentsParentId
     *
     * Your GET endpoint.
     *
     */
    public function testGetParentsParentId()
    {
        $client = static::createClient();

        $path = '/parents/{parentId}';
        $pattern = '{parentId}';
        $data = $this->genTestData('[a-z0-9]+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('GET', $path);
    }

    /**
     * Test case for getParentsParentIdMembers
     *
     * Your GET endpoint.
     *
     */
    public function testGetParentsParentIdMembers()
    {
        $client = static::createClient();

        $path = '/parents/{parentId}/members';
        $pattern = '{parentId}';
        $data = $this->genTestData('[a-z0-9]+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('GET', $path);
    }

    /**
     * Test case for postParents
     *
     * .
     *
     */
    public function testPostParents()
    {
        $client = static::createClient();

        $path = '/parents';

        $crawler = $client->request('POST', $path);
    }

    /**
     * Test case for putGroupsGroupId
     *
     * .
     *
     */
    public function testPutGroupsGroupId()
    {
        $client = static::createClient();

        $path = '/groups/{groupId}';
        $pattern = '{groupId}';
        $data = $this->genTestData('[a-z0-9]+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('PUT', $path);
    }

    /**
     * Test case for putParentsParentId
     *
     * .
     *
     */
    public function testPutParentsParentId()
    {
        $client = static::createClient();

        $path = '/parents/{parentId}';
        $pattern = '{parentId}';
        $data = $this->genTestData('[a-z0-9]+');
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
