<?php

/**
 * GroupsController
 * PHP version 5
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
use OpenAPI\Server\Api\GroupsApiInterface;
use OpenAPI\Server\Model\ApiResponse;
use OpenAPI\Server\Model\GroupData;
use OpenAPI\Server\Model\GroupInput;
use OpenAPI\Server\Model\MemberData;
use OpenAPI\Server\Model\SectionData;

/**
 * GroupsController Class Doc Comment
 *
 * @category Class
 * @package  OpenAPI\Server\Controller
 * @author   OpenAPI Generator team
 * @link     https://github.com/openapitools/openapi-generator
 */
class GroupsController extends Controller
{

    /**
     * Operation addGroupLocalMarkerById
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function addGroupLocalMarkerByIdAction(Request $request, $groupId)
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

        // Read out all input parameter values into variables

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $groupId = $this->deserialize($groupId, 'string', 'string');
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\Type("string");
        $response = $this->validate($groupId, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'contact_auth'
            $handler->setcontact_auth($securitycontact_auth);
            
            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];
            $result = $handler->addGroupLocalMarkerById($groupId, $responseCode, $responseHeaders);

            // Find default response message
            $message = 'OK';

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
     * Operation createGroup
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function createGroupAction(Request $request)
    {
        // Make sure that the client is providing something that we can consume
        $consumes = ['application/json'];
        $inputFormat = $request->headers->has('Content-Type')?$request->headers->get('Content-Type'):$consumes[0];
        if (!in_array($inputFormat, $consumes)) {
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

        // Read out all input parameter values into variables
        $groupInput = $request->getContent();

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $groupInput = $this->deserialize($groupInput, 'OpenAPI\Server\Model\GroupInput', $inputFormat);
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\Type("OpenAPI\Server\Model\GroupInput");
        $asserts[] = new Assert\Valid();
        $response = $this->validate($groupInput, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'contact_auth'
            $handler->setcontact_auth($securitycontact_auth);
            
            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];
            $result = $handler->createGroup($groupInput, $responseCode, $responseHeaders);

            // Find default response message
            $message = 'OK';

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
     * Operation deleteGroupById
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function deleteGroupByIdAction(Request $request, $groupId)
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

        // Read out all input parameter values into variables

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $groupId = $this->deserialize($groupId, 'string', 'string');
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\Type("string");
        $response = $this->validate($groupId, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'contact_auth'
            $handler->setcontact_auth($securitycontact_auth);
            
            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];
            $result = $handler->deleteGroupById($groupId, $responseCode, $responseHeaders);

            // Find default response message
            $message = 'OK';

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
     * Operation deleteGroupLocalMarkerById
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function deleteGroupLocalMarkerByIdAction(Request $request, $groupId)
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

        // Read out all input parameter values into variables

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $groupId = $this->deserialize($groupId, 'string', 'string');
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\Type("string");
        $response = $this->validate($groupId, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'contact_auth'
            $handler->setcontact_auth($securitycontact_auth);
            
            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];
            $result = $handler->deleteGroupLocalMarkerById($groupId, $responseCode, $responseHeaders);

            // Find default response message
            $message = 'OK';

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
     * Operation getGroupById
     *
     * Your GET endpoint
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function getGroupByIdAction(Request $request, $groupId)
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

        // Read out all input parameter values into variables

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $groupId = $this->deserialize($groupId, 'string', 'string');
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\Type("string");
        $response = $this->validate($groupId, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'contact_auth'
            $handler->setcontact_auth($securitycontact_auth);
            
            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];
            $result = $handler->getGroupById($groupId, $responseCode, $responseHeaders);

            // Find default response message
            $message = 'OK';

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
     * Operation getGroupMembersById
     *
     * Your GET endpoint
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function getGroupMembersByIdAction(Request $request, $groupId)
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

        // Read out all input parameter values into variables

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $groupId = $this->deserialize($groupId, 'string', 'string');
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\Type("string");
        $response = $this->validate($groupId, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'contact_auth'
            $handler->setcontact_auth($securitycontact_auth);
            
            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];
            $result = $handler->getGroupMembersById($groupId, $responseCode, $responseHeaders);

            // Find default response message
            $message = 'OK';

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
     * Operation getGroupSectionsById
     *
     * Your GET endpoint
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function getGroupSectionsByIdAction(Request $request, $groupId)
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

        // Read out all input parameter values into variables

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $groupId = $this->deserialize($groupId, 'string', 'string');
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\Type("string");
        $response = $this->validate($groupId, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'contact_auth'
            $handler->setcontact_auth($securitycontact_auth);
            
            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];
            $result = $handler->getGroupSectionsById($groupId, $responseCode, $responseHeaders);

            // Find default response message
            $message = 'OK';

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
     * Operation getGroups
     *
     * Your GET endpoint
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function getGroupsAction(Request $request)
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

        // Read out all input parameter values into variables
        $sort = $request->query->get('sort');
        $pageSize = $request->query->get('pageSize');
        $page = $request->query->get('page');

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $sort = $this->deserialize($sort, 'string', 'string');
            $pageSize = $this->deserialize($pageSize, 'int', 'string');
            $page = $this->deserialize($page, 'int', 'string');
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
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
            
            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];
            $result = $handler->getGroups($sort, $pageSize, $page, $responseCode, $responseHeaders);

            // Find default response message
            $message = 'OK';

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
     * Operation updateGroupById
     *
     * @param Request $request The Symfony request to handle.
     * @return Response The Symfony response.
     */
    public function updateGroupByIdAction(Request $request, $groupId)
    {
        // Make sure that the client is providing something that we can consume
        $consumes = ['application/json'];
        $inputFormat = $request->headers->has('Content-Type')?$request->headers->get('Content-Type'):$consumes[0];
        if (!in_array($inputFormat, $consumes)) {
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

        // Read out all input parameter values into variables
        $groupInput = $request->getContent();

        // Use the default value if no value was provided

        // Deserialize the input values that needs it
        try {
            $groupId = $this->deserialize($groupId, 'string', 'string');
            $groupInput = $this->deserialize($groupInput, 'OpenAPI\Server\Model\GroupInput', $inputFormat);
        } catch (SerializerRuntimeException $exception) {
            return $this->createBadRequestResponse($exception->getMessage());
        }

        // Validate the input values
        $asserts = [];
        $asserts[] = new Assert\NotNull();
        $asserts[] = new Assert\Type("string");
        $response = $this->validate($groupId, $asserts);
        if ($response instanceof Response) {
            return $response;
        }
        $asserts = [];
        $asserts[] = new Assert\Type("OpenAPI\Server\Model\GroupInput");
        $asserts[] = new Assert\Valid();
        $response = $this->validate($groupInput, $asserts);
        if ($response instanceof Response) {
            return $response;
        }


        try {
            $handler = $this->getApiHandler();

            // Set authentication method 'contact_auth'
            $handler->setcontact_auth($securitycontact_auth);
            
            // Make the call to the business logic
            $responseCode = 200;
            $responseHeaders = [];
            $result = $handler->updateGroupById($groupId, $groupInput, $responseCode, $responseHeaders);

            // Find default response message
            $message = 'OK';

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
     * @return GroupsApiInterface
     */
    public function getApiHandler()
    {
        return $this->apiServer->getApiHandler('groups');
    }
}
