# OpenAPI\Server\Api\GroupsApiInterface

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addGroupLocalMarkerById**](GroupsApiInterface.md#addGroupLocalMarkerById) | **PUT** /groups/{groupId}/local | 
[**createGroup**](GroupsApiInterface.md#createGroup) | **POST** /groups | 
[**deleteGroupLocalMarkerById**](GroupsApiInterface.md#deleteGroupLocalMarkerById) | **DELETE** /groups/{groupId}/local | 
[**getGroupMembersById**](GroupsApiInterface.md#getGroupMembersById) | **GET** /groups/{groupId}/members | Your GET endpoint
[**getGroupSectionsById**](GroupsApiInterface.md#getGroupSectionsById) | **GET** /groups/{groupId}/sections | Your GET endpoint
[**getGroups**](GroupsApiInterface.md#getGroups) | **GET** /groups | Your GET endpoint


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

## **addGroupLocalMarkerById**
> OpenAPI\Server\Model\ApiResponse addGroupLocalMarkerById($groupId)



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
     * Implementation of GroupsApiInterface#addGroupLocalMarkerById
     */
    public function addGroupLocalMarkerById($groupId)
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

## **createGroup**
> OpenAPI\Server\Model\Group createGroup($group)



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
     * Implementation of GroupsApiInterface#createGroup
     */
    public function createGroup(Group $group = null)
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

## **deleteGroupLocalMarkerById**
> OpenAPI\Server\Model\ApiResponse deleteGroupLocalMarkerById($groupId)



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
     * Implementation of GroupsApiInterface#deleteGroupLocalMarkerById
     */
    public function deleteGroupLocalMarkerById($groupId)
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

## **getGroupMembersById**
> string getGroupMembersById($groupId)

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
     * Implementation of GroupsApiInterface#getGroupMembersById
     */
    public function getGroupMembersById($groupId)
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

## **getGroupSectionsById**
> string getGroupSectionsById($groupId)

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
     * Implementation of GroupsApiInterface#getGroupSectionsById
     */
    public function getGroupSectionsById($groupId)
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

