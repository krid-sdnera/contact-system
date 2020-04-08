# OpenAPI\Server\Api\GroupsApiInterface

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**deleteGroupsGroupIdLocal**](GroupsApiInterface.md#deleteGroupsGroupIdLocal) | **DELETE** /groups/{groupId}/local | 
[**getGroups**](GroupsApiInterface.md#getGroups) | **GET** /groups | Your GET endpoint
[**getGroupsGroupIdMembers**](GroupsApiInterface.md#getGroupsGroupIdMembers) | **GET** /groups/{groupId}/members | Your GET endpoint
[**getGroupsGroupIdSections**](GroupsApiInterface.md#getGroupsGroupIdSections) | **GET** /groups/{groupId}/sections | Your GET endpoint
[**postGroups**](GroupsApiInterface.md#postGroups) | **POST** /groups | 
[**putGroupsGroupIdLocal**](GroupsApiInterface.md#putGroupsGroupIdLocal) | **PUT** /groups/{groupId}/local | 


## Service Declaration
```yaml
# src/Acme/MyBundle/Resources/services.yml
services:
    # ...
    acme.my_bundle.api.groups:
        class: Acme\MyBundle\Api\GroupsApi
        tags:
            - { name: "open_api_server.api", api: "groups" }
    # ...
```

## **deleteGroupsGroupIdLocal**
> OpenAPI\Server\Model\ApiResponse deleteGroupsGroupIdLocal($groupId)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/GroupsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\GroupsApiInterface;

class GroupsApi implements GroupsApiInterface
{

    /**
     * Configure API key authorization: contact_auth
     */
    public function setcontact_auth($apiKey)
    {
        // Retrieve logged in user from $apiKey ...
    }

    // ...

    /**
     * Implementation of GroupsApiInterface#deleteGroupsGroupIdLocal
     */
    public function deleteGroupsGroupIdLocal($groupId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **groupId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getGroups**
> OpenAPI\Server\Model\Group getGroups()

Your GET endpoint

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/GroupsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\GroupsApiInterface;

class GroupsApi implements GroupsApiInterface
{

    /**
     * Configure API key authorization: contact_auth
     */
    public function setcontact_auth($apiKey)
    {
        // Retrieve logged in user from $apiKey ...
    }

    // ...

    /**
     * Implementation of GroupsApiInterface#getGroups
     */
    public function getGroups()
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**OpenAPI\Server\Model\Group**](../Model/Group.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getGroupsGroupIdMembers**
> string getGroupsGroupIdMembers($groupId)

Your GET endpoint

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/GroupsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\GroupsApiInterface;

class GroupsApi implements GroupsApiInterface
{

    /**
     * Configure API key authorization: contact_auth
     */
    public function setcontact_auth($apiKey)
    {
        // Retrieve logged in user from $apiKey ...
    }

    // ...

    /**
     * Implementation of GroupsApiInterface#getGroupsGroupIdMembers
     */
    public function getGroupsGroupIdMembers($groupId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **groupId** | **string**|  |

### Return type

**string**

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getGroupsGroupIdSections**
> string getGroupsGroupIdSections($groupId)

Your GET endpoint

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/GroupsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\GroupsApiInterface;

class GroupsApi implements GroupsApiInterface
{

    /**
     * Configure API key authorization: contact_auth
     */
    public function setcontact_auth($apiKey)
    {
        // Retrieve logged in user from $apiKey ...
    }

    // ...

    /**
     * Implementation of GroupsApiInterface#getGroupsGroupIdSections
     */
    public function getGroupsGroupIdSections($groupId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **groupId** | **string**|  |

### Return type

**string**

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **postGroups**
> OpenAPI\Server\Model\Group postGroups($group)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/GroupsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\GroupsApiInterface;

class GroupsApi implements GroupsApiInterface
{

    /**
     * Configure API key authorization: contact_auth
     */
    public function setcontact_auth($apiKey)
    {
        // Retrieve logged in user from $apiKey ...
    }

    // ...

    /**
     * Implementation of GroupsApiInterface#postGroups
     */
    public function postGroups(Group $group = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **group** | [**OpenAPI\Server\Model\Group**](../Model/Group.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\Group**](../Model/Group.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **putGroupsGroupIdLocal**
> OpenAPI\Server\Model\ApiResponse putGroupsGroupIdLocal($groupId)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/GroupsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\GroupsApiInterface;

class GroupsApi implements GroupsApiInterface
{

    /**
     * Configure API key authorization: contact_auth
     */
    public function setcontact_auth($apiKey)
    {
        // Retrieve logged in user from $apiKey ...
    }

    // ...

    /**
     * Implementation of GroupsApiInterface#putGroupsGroupIdLocal
     */
    public function putGroupsGroupIdLocal($groupId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **groupId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

