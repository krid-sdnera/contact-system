<?php

/**
 * ScoutGroupsController
 * PHP version 7.1.3
 *
 * @category Class
 * @package  OpenAPI\Server\Controller
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

namespace OpenAPI\Server\Controller;

use \Exception;
use JMS\Serializer\Exception\RuntimeException as SerializerRuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Validator\Constraints as Assert;
use OpenAPI\Server\Api\ScoutGroupsApiInterface;
use OpenAPI\Server\Model\ApiResponse;
use OpenAPI\Server\Model\ListRules;
use OpenAPI\Server\Model\ScoutGroupInput;
use OpenAPI\Server\Model\ScoutGroupResponse;
use OpenAPI\Server\Model\ScoutGroups;
use OpenAPI\Server\Model\Sections;

/**
 * ScoutGroupsController Class Doc Comment
 *
 * @category Class
 * @package  OpenAPI\Server\Controller
 * @author   OpenAPI Generator team
 * @link     https://github.com/openapitools/openapi-generator
 */
class ScoutGroupsController extends Controller
{

    /**
     * Operation createScoutGroup
     *
     * Create Group
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function createScoutGroupAction(Request $request)
    {
        // Make sure that the client is providing something that we can consume
        $consumes = ['application/json'];
        if (!static::isContentTypeAllowed($request, $consumes)) {
            // We can't consume the content that the client is sending us
            return new Response('', 415);
        }

        // Figure out what data format to return to the client
        $produces = ['application/json'];
        // Figure out what the client accepts
        $clientAccepts = $request->headers->has('Accept')?$request->headers->get('Accept'):'*/*';
        $responseFormat = $this->getOutputFormat($clientAccepts, $produces);
        if ($responseFormat === null) {
            return new Response('', 406);
        }

        // Handle authentication
        // Authentication 'contact_auth' required
        // Set key with prefix in header
        $securitycontact_auth = $request->headers->get('x-auth-token');
        // Authentication 'jwt_auth' required
        // HTTP basic authentication required
        $securityjwt_auth = $request->headers->get('authorization');

        // Read out all input parameter values into variables
        $scoutGroupInput = $request->getContent();

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $inputFormat = $request->getMimeType($request->getContentType());
            $scoutGroupInput = $this->deserialize($scoutGroupInput, 'OpenAPI\Server\Model\ScoutGroupInput', $inputFormat);
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\Type("OpenAPI\Server\Model\ScoutGroupInput");
        $asserts[] = new Assert\Valid();
        $response = $this->validate($scoutGroupInput, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'contact_auth'
            $handler->setcontact_auth($securitycontact_auth);
            // Set authentication method 'jwt_auth'
            $handler->setjwt_auth($securityjwt_auth);
            
            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];
            $result = $handler->createScoutGroup($scoutGroupInput, $responseCode, $responseHeaders);

            // Find default response message
            $message = '';

            // Find a more specific message, if available
            switch ($responseCode) {
                case 200:
                    $message = 'OK';
                    break;
            }

            return new Response(
                $result !== null ?$this->serialize($result, $responseFormat):'',
                $responseCode,
                array_merge(
                    $responseHeaders,
                    [
                        'Content-Type' => $responseFormat,
                        'X-OpenAPI-Message' => $message
                    ]
                )
            );
        } catch (AccessDeniedException $accessDenied) {
            // Fall through to Symfony Guard Authenticator by rethrowing
            throw $accessDenied;
        } catch (Exception $fallthrough) {
            return $this->createErrorResponse(new HttpException(500, 'An unsuspected error occurred.', $fallthrough));
        }
    }

    /**
     * Operation deleteScoutGroupById
     *
     * Delete Group
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function deleteScoutGroupByIdAction(Request $request, $scoutGroupId)
    {
        // Figure out what data format to return to the client
        $produces = ['application/json'];
        // Figure out what the client accepts
        $clientAccepts = $request->headers->has('Accept')?$request->headers->get('Accept'):'*/*';
        $responseFormat = $this->getOutputFormat($clientAccepts, $produces);
        if ($responseFormat === null) {
            return new Response('', 406);
        }

        // Handle authentication
        // Authentication 'contact_auth' required
        // Set key with prefix in header
        $securitycontact_auth = $request->headers->get('x-auth-token');
        // Authentication 'jwt_auth' required
        // HTTP basic authentication required
        $securityjwt_auth = $request->headers->get('authorization');

        // Read out all input parameter values into variables

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $scoutGroupId = $this->deserialize($scoutGroupId, 'int', 'string');
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\Type("int");
        $response = $this->validate($scoutGroupId, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'contact_auth'
            $handler->setcontact_auth($securitycontact_auth);
            // Set authentication method 'jwt_auth'
            $handler->setjwt_auth($securityjwt_auth);
            
            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];
            $result = $handler->deleteScoutGroupById($scoutGroupId, $responseCode, $responseHeaders);

            // Find default response message
            $message = '';

            // Find a more specific message, if available
            switch ($responseCode) {
                case 200:
                    $message = 'OK';
                    break;
            }

            return new Response(
                $result !== null ?$this->serialize($result, $responseFormat):'',
                $responseCode,
                array_merge(
                    $responseHeaders,
                    [
                        'Content-Type' => $responseFormat,
                        'X-OpenAPI-Message' => $message
                    ]
                )
            );
        } catch (AccessDeniedException $accessDenied) {
            // Fall through to Symfony Guard Authenticator by rethrowing
            throw $accessDenied;
        } catch (Exception $fallthrough) {
            return $this->createErrorResponse(new HttpException(500, 'An unsuspected error occurred.', $fallthrough));
        }
    }

    /**
     * Operation getListRulesByScoutGroupId
     *
     * Get List Rules By Scout Group ID
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function getListRulesByScoutGroupIdAction(Request $request, $scoutGroupId)
    {
        // Figure out what data format to return to the client
        $produces = ['application/json'];
        // Figure out what the client accepts
        $clientAccepts = $request->headers->has('Accept')?$request->headers->get('Accept'):'*/*';
        $responseFormat = $this->getOutputFormat($clientAccepts, $produces);
        if ($responseFormat === null) {
            return new Response('', 406);
        }

        // Handle authentication
        // Authentication 'contact_auth' required
        // Set key with prefix in header
        $securitycontact_auth = $request->headers->get('x-auth-token');
        // Authentication 'jwt_auth' required
        // HTTP basic authentication required
        $securityjwt_auth = $request->headers->get('authorization');

        // Read out all input parameter values into variables
        $query = $request->query->get('query');
        $sort = $request->query->get('sort');
        $pageSize = $request->query->get('pageSize');
        $page = $request->query->get('page');

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $scoutGroupId = $this->deserialize($scoutGroupId, 'int', 'string');
            $query = $this->deserialize($query, 'string', 'string');
            $sort = $this->deserialize($sort, 'string', 'string');
            $pageSize = $this->deserialize($pageSize, 'int', 'string');
            $page = $this->deserialize($page, 'int', 'string');
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\Type("int");
        $response = $this->validate($scoutGroupId, $asserts);
        if ($response instanceof Response) {
            return $response;
        }
        $asserts = [];
        $asserts[] = new Assert\Type("string");
        $response = $this->validate($query, $asserts);
        if ($response instanceof Response) {
            return $response;
        }
        $asserts = [];
        $asserts[] = new Assert\Type("string");
        $response = $this->validate($sort, $asserts);
        if ($response instanceof Response) {
            return $response;
        }
        $asserts = [];
        $asserts[] = new Assert\Type("int");
        $response = $this->validate($pageSize, $asserts);
        if ($response instanceof Response) {
            return $response;
        }
        $asserts = [];
        $asserts[] = new Assert\Type("int");
        $response = $this->validate($page, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'contact_auth'
            $handler->setcontact_auth($securitycontact_auth);
            // Set authentication method 'jwt_auth'
            $handler->setjwt_auth($securityjwt_auth);
            
            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];
            $result = $handler->getListRulesByScoutGroupId($scoutGroupId, $query, $sort, $pageSize, $page, $responseCode, $responseHeaders);

            // Find default response message
            $message = '';

            // Find a more specific message, if available
            switch ($responseCode) {
                case 200:
                    $message = 'OK';
                    break;
            }

            return new Response(
                $result !== null ?$this->serialize($result, $responseFormat):'',
                $responseCode,
                array_merge(
                    $responseHeaders,
                    [
                        'Content-Type' => $responseFormat,
                        'X-OpenAPI-Message' => $message
                    ]
                )
            );
        } catch (AccessDeniedException $accessDenied) {
            // Fall through to Symfony Guard Authenticator by rethrowing
            throw $accessDenied;
        } catch (Exception $fallthrough) {
            return $this->createErrorResponse(new HttpException(500, 'An unsuspected error occurred.', $fallthrough));
        }
    }

    /**
     * Operation getScoutGroupById
     *
     * Get Group
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function getScoutGroupByIdAction(Request $request, $scoutGroupId)
    {
        // Figure out what data format to return to the client
        $produces = ['application/json'];
        // Figure out what the client accepts
        $clientAccepts = $request->headers->has('Accept')?$request->headers->get('Accept'):'*/*';
        $responseFormat = $this->getOutputFormat($clientAccepts, $produces);
        if ($responseFormat === null) {
            return new Response('', 406);
        }

        // Handle authentication
        // Authentication 'contact_auth' required
        // Set key with prefix in header
        $securitycontact_auth = $request->headers->get('x-auth-token');
        // Authentication 'jwt_auth' required
        // HTTP basic authentication required
        $securityjwt_auth = $request->headers->get('authorization');

        // Read out all input parameter values into variables

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $scoutGroupId = $this->deserialize($scoutGroupId, 'int', 'string');
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\Type("int");
        $response = $this->validate($scoutGroupId, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'contact_auth'
            $handler->setcontact_auth($securitycontact_auth);
            // Set authentication method 'jwt_auth'
            $handler->setjwt_auth($securityjwt_auth);
            
            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];
            $result = $handler->getScoutGroupById($scoutGroupId, $responseCode, $responseHeaders);

            // Find default response message
            $message = '';

            // Find a more specific message, if available
            switch ($responseCode) {
                case 200:
                    $message = 'OK';
                    break;
            }

            return new Response(
                $result !== null ?$this->serialize($result, $responseFormat):'',
                $responseCode,
                array_merge(
                    $responseHeaders,
                    [
                        'Content-Type' => $responseFormat,
                        'X-OpenAPI-Message' => $message
                    ]
                )
            );
        } catch (AccessDeniedException $accessDenied) {
            // Fall through to Symfony Guard Authenticator by rethrowing
            throw $accessDenied;
        } catch (Exception $fallthrough) {
            return $this->createErrorResponse(new HttpException(500, 'An unsuspected error occurred.', $fallthrough));
        }
    }

    /**
     * Operation getScoutGroupSectionsByScoutGroupId
     *
     * Get Scout Group Sections By Scout Group ID
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function getScoutGroupSectionsByScoutGroupIdAction(Request $request, $scoutGroupId)
    {
        // Figure out what data format to return to the client
        $produces = ['application/json'];
        // Figure out what the client accepts
        $clientAccepts = $request->headers->has('Accept')?$request->headers->get('Accept'):'*/*';
        $responseFormat = $this->getOutputFormat($clientAccepts, $produces);
        if ($responseFormat === null) {
            return new Response('', 406);
        }

        // Handle authentication
        // Authentication 'contact_auth' required
        // Set key with prefix in header
        $securitycontact_auth = $request->headers->get('x-auth-token');
        // Authentication 'jwt_auth' required
        // HTTP basic authentication required
        $securityjwt_auth = $request->headers->get('authorization');

        // Read out all input parameter values into variables

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $scoutGroupId = $this->deserialize($scoutGroupId, 'int', 'string');
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\Type("int");
        $response = $this->validate($scoutGroupId, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'contact_auth'
            $handler->setcontact_auth($securitycontact_auth);
            // Set authentication method 'jwt_auth'
            $handler->setjwt_auth($securityjwt_auth);
            
            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];
            $result = $handler->getScoutGroupSectionsByScoutGroupId($scoutGroupId, $responseCode, $responseHeaders);

            // Find default response message
            $message = '';

            // Find a more specific message, if available
            switch ($responseCode) {
                case 200:
                    $message = 'OK';
                    break;
            }

            return new Response(
                $result !== null ?$this->serialize($result, $responseFormat):'',
                $responseCode,
                array_merge(
                    $responseHeaders,
                    [
                        'Content-Type' => $responseFormat,
                        'X-OpenAPI-Message' => $message
                    ]
                )
            );
        } catch (AccessDeniedException $accessDenied) {
            // Fall through to Symfony Guard Authenticator by rethrowing
            throw $accessDenied;
        } catch (Exception $fallthrough) {
            return $this->createErrorResponse(new HttpException(500, 'An unsuspected error occurred.', $fallthrough));
        }
    }

    /**
     * Operation getScoutGroups
     *
     * Get Groups
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function getScoutGroupsAction(Request $request)
    {
        // Figure out what data format to return to the client
        $produces = ['application/json'];
        // Figure out what the client accepts
        $clientAccepts = $request->headers->has('Accept')?$request->headers->get('Accept'):'*/*';
        $responseFormat = $this->getOutputFormat($clientAccepts, $produces);
        if ($responseFormat === null) {
            return new Response('', 406);
        }

        // Handle authentication
        // Authentication 'contact_auth' required
        // Set key with prefix in header
        $securitycontact_auth = $request->headers->get('x-auth-token');
        // Authentication 'jwt_auth' required
        // HTTP basic authentication required
        $securityjwt_auth = $request->headers->get('authorization');

        // Read out all input parameter values into variables
        $query = $request->query->get('query');
        $sort = $request->query->get('sort');
        $pageSize = $request->query->get('pageSize');
        $page = $request->query->get('page');

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $query = $this->deserialize($query, 'string', 'string');
            $sort = $this->deserialize($sort, 'string', 'string');
            $pageSize = $this->deserialize($pageSize, 'int', 'string');
            $page = $this->deserialize($page, 'int', 'string');
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\Type("string");
        $response = $this->validate($query, $asserts);
        if ($response instanceof Response) {
            return $response;
        }
        $asserts = [];
        $asserts[] = new Assert\Type("string");
        $response = $this->validate($sort, $asserts);
        if ($response instanceof Response) {
            return $response;
        }
        $asserts = [];
        $asserts[] = new Assert\Type("int");
        $response = $this->validate($pageSize, $asserts);
        if ($response instanceof Response) {
            return $response;
        }
        $asserts = [];
        $asserts[] = new Assert\Type("int");
        $response = $this->validate($page, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'contact_auth'
            $handler->setcontact_auth($securitycontact_auth);
            // Set authentication method 'jwt_auth'
            $handler->setjwt_auth($securityjwt_auth);
            
            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];
            $result = $handler->getScoutGroups($query, $sort, $pageSize, $page, $responseCode, $responseHeaders);

            // Find default response message
            $message = '';

            // Find a more specific message, if available
            switch ($responseCode) {
                case 200:
                    $message = 'OK';
                    break;
            }

            return new Response(
                $result !== null ?$this->serialize($result, $responseFormat):'',
                $responseCode,
                array_merge(
                    $responseHeaders,
                    [
                        'Content-Type' => $responseFormat,
                        'X-OpenAPI-Message' => $message
                    ]
                )
            );
        } catch (AccessDeniedException $accessDenied) {
            // Fall through to Symfony Guard Authenticator by rethrowing
            throw $accessDenied;
        } catch (Exception $fallthrough) {
            return $this->createErrorResponse(new HttpException(500, 'An unsuspected error occurred.', $fallthrough));
        }
    }

    /**
     * Operation updateScoutGroupById
     *
     * Update Group
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function updateScoutGroupByIdAction(Request $request, $scoutGroupId)
    {
        // Make sure that the client is providing something that we can consume
        $consumes = ['application/json'];
        if (!static::isContentTypeAllowed($request, $consumes)) {
            // We can't consume the content that the client is sending us
            return new Response('', 415);
        }

        // Figure out what data format to return to the client
        $produces = ['application/json'];
        // Figure out what the client accepts
        $clientAccepts = $request->headers->has('Accept')?$request->headers->get('Accept'):'*/*';
        $responseFormat = $this->getOutputFormat($clientAccepts, $produces);
        if ($responseFormat === null) {
            return new Response('', 406);
        }

        // Handle authentication
        // Authentication 'contact_auth' required
        // Set key with prefix in header
        $securitycontact_auth = $request->headers->get('x-auth-token');
        // Authentication 'jwt_auth' required
        // HTTP basic authentication required
        $securityjwt_auth = $request->headers->get('authorization');

        // Read out all input parameter values into variables
        $scoutGroupInput = $request->getContent();

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $scoutGroupId = $this->deserialize($scoutGroupId, 'int', 'string');
            $inputFormat = $request->getMimeType($request->getContentType());
            $scoutGroupInput = $this->deserialize($scoutGroupInput, 'OpenAPI\Server\Model\ScoutGroupInput', $inputFormat);
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\Type("int");
        $response = $this->validate($scoutGroupId, $asserts);
        if ($response instanceof Response) {
            return $response;
        }
        $asserts = [];
        $asserts[] = new Assert\Type("OpenAPI\Server\Model\ScoutGroupInput");
        $asserts[] = new Assert\Valid();
        $response = $this->validate($scoutGroupInput, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'contact_auth'
            $handler->setcontact_auth($securitycontact_auth);
            // Set authentication method 'jwt_auth'
            $handler->setjwt_auth($securityjwt_auth);
            
            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];
            $result = $handler->updateScoutGroupById($scoutGroupId, $scoutGroupInput, $responseCode, $responseHeaders);

            // Find default response message
            $message = '';

            // Find a more specific message, if available
            switch ($responseCode) {
                case 200:
                    $message = 'OK';
                    break;
            }

            return new Response(
                $result !== null ?$this->serialize($result, $responseFormat):'',
                $responseCode,
                array_merge(
                    $responseHeaders,
                    [
                        'Content-Type' => $responseFormat,
                        'X-OpenAPI-Message' => $message
                    ]
                )
            );
        } catch (AccessDeniedException $accessDenied) {
            // Fall through to Symfony Guard Authenticator by rethrowing
            throw $accessDenied;
        } catch (Exception $fallthrough) {
            return $this->createErrorResponse(new HttpException(500, 'An unsuspected error occurred.', $fallthrough));
        }
    }

    /**
     * Returns the handler for this API controller.
     * @return ScoutGroupsApiInterface
     */
    public function getApiHandler()
    {
        return $this->apiServer->getApiHandler('scoutGroups');
    }
}
