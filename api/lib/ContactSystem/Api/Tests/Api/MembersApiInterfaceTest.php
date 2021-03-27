<?php
/**
 * MembersApiInterfaceTest
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
 * MembersApiInterfaceTest Class Doc Comment
 *
 * @category Class
 * @package  OpenAPI\Server\Tests\Api
 * @author   openapi-generator contributors
 * @link     https://github.com/openapitools/openapi-generator
 */
class MembersApiInterfaceTest extends WebTestCase
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
     * Test case for addMemberRoleById
     *
     * Add Member Role.
     *
     */
    public function testAddMemberRoleById()
    {
        $client = static::createClient();

        $path = '/members/{memberId}/roles/{roleId}';
        $pattern = '{memberId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);
        $pattern = '{roleId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('PUT', $path);
    }

    /**
     * Test case for createMember
     *
     * Create a member.
     *
     */
    public function testCreateMember()
    {
        $client = static::createClient();

        $path = '/members';

        $crawler = $client->request('POST', $path);
    }

    /**
     * Test case for deleteMemberById
     *
     * Delete member.
     *
     */
    public function testDeleteMemberById()
    {
        $client = static::createClient();

        $path = '/members/{memberId}';
        $pattern = '{memberId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('DELETE', $path);
    }

    /**
     * Test case for getListRulesByMemberId
     *
     * Your GET endpoint.
     *
     */
    public function testGetListRulesByMemberId()
    {
        $client = static::createClient();

        $path = '/members/{memberId}/list-rules';
        $pattern = '{memberId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('GET', $path);
    }

    /**
     * Test case for getMemberById
     *
     * Get member.
     *
     */
    public function testGetMemberById()
    {
        $client = static::createClient();

        $path = '/members/{memberId}';
        $pattern = '{memberId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('GET', $path);
    }

    /**
     * Test case for getMemberContactsById
     *
     * List member's contacts.
     *
     */
    public function testGetMemberContactsById()
    {
        $client = static::createClient();

        $path = '/members/{memberId}/contacts';
        $pattern = '{memberId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('GET', $path);
    }

    /**
     * Test case for getMemberRolesById
     *
     * List member's roles.
     *
     */
    public function testGetMemberRolesById()
    {
        $client = static::createClient();

        $path = '/members/{memberId}/roles';
        $pattern = '{memberId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('GET', $path);
    }

    /**
     * Test case for getMembers
     *
     * List all members.
     *
     */
    public function testGetMembers()
    {
        $client = static::createClient();

        $path = '/members';

        $crawler = $client->request('GET', $path);
    }

    /**
     * Test case for mergeMember
     *
     * Merge member.
     *
     */
    public function testMergeMember()
    {
        $client = static::createClient();

        $path = '/members/{memberId}/merge_into/{mergeMemberId}';
        $pattern = '{memberId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);
        $pattern = '{mergeMemberId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('POST', $path);
    }

    /**
     * Test case for patchMemberById
     *
     * Partially update member.
     *
     */
    public function testPatchMemberById()
    {
        $client = static::createClient();

        $path = '/members/{memberId}';
        $pattern = '{memberId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('PATCH', $path);
    }

    /**
     * Test case for removeMemberRoleById
     *
     * Remove Member Role.
     *
     */
    public function testRemoveMemberRoleById()
    {
        $client = static::createClient();

        $path = '/members/{memberId}/roles/{roleId}';
        $pattern = '{memberId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);
        $pattern = '{roleId}';
        $data = $this->genTestData('\d+');
        $path = str_replace($pattern, $data, $path);

        $crawler = $client->request('DELETE', $path);
    }

    /**
     * Test case for updateMemberById
     *
     * Update member.
     *
     */
    public function testUpdateMemberById()
    {
        $client = static::createClient();

        $path = '/members/{memberId}';
        $pattern = '{memberId}';
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
