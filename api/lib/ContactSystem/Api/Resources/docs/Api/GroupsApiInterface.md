# OpenAPI\Server\Api\GroupsApiInterface

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addGroupLocalMarkerById**](GroupsApiInterface.md#addGroupLocalMarkerById) | **PUT** /groups/{groupId}/local | 
[**createGroup**](GroupsApiInterface.md#createGroup) | **POST** /groups | Create Group
[**deleteGroupById**](GroupsApiInterface.md#deleteGroupById) | **DELETE** /groups/{groupId} | Delete Group
[**deleteGroupLocalMarkerById**](GroupsApiInterface.md#deleteGroupLocalMarkerById) | **DELETE** /groups/{groupId}/local | 
[**getGroupById**](GroupsApiInterface.md#getGroupById) | **GET** /groups/{groupId} | Get Group
[**getGroupMembersById**](GroupsApiInterface.md#getGroupMembersById) | **GET** /groups/{groupId}/members | Your GET endpoint
[**getGroupSectionsById**](GroupsApiInterface.md#getGroupSectionsById) | **GET** /groups/{groupId}/sections | Your GET endpoint
[**getGroups**](GroupsApiInterface.md#getGroups) | **GET** /groups | Get Groups
[**updateGroupById**](GroupsApiInterface.md#updateGroupById) | **PUT** /groups/{groupId} | Update Group


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



addGroupLocalMarkerById

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
    public function addGroupLocalMarkerById(int $groupId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **groupId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **createGroup**
> OpenAPI\Server\Model\ScoutGroupData createGroup($scoutGroupInput)

Create Group

Create Group

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
    public function createGroup(ScoutGroupInput $scoutGroupInput = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **scoutGroupInput** | [**OpenAPI\Server\Model\ScoutGroupInput**](../Model/ScoutGroupInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\ScoutGroupData**](../Model/ScoutGroupData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **deleteGroupById**
> OpenAPI\Server\Model\ApiResponse deleteGroupById($groupId)

Delete Group

Delete Group

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
     * Implementation of GroupsApiInterface#deleteGroupById
     */
    public function deleteGroupById(int $groupId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **groupId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **deleteGroupLocalMarkerById**
> OpenAPI\Server\Model\ApiResponse deleteGroupLocalMarkerById($groupId)



deleteGroupLocalMarkerById

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
    public function deleteGroupLocalMarkerById(int $groupId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **groupId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getGroupById**
> OpenAPI\Server\Model\ScoutGroupData getGroupById($groupId)

Get Group

Get Group

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
     * Implementation of GroupsApiInterface#getGroupById
     */
    public function getGroupById(int $groupId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **groupId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\ScoutGroupData**](../Model/ScoutGroupData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getGroupMembersById**
> OpenAPI\Server\Model\MemberData getGroupMembersById($groupId)

Your GET endpoint

getGroupMembersById

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
    public function getGroupMembersById(int $groupId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **groupId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\MemberData**](../Model/MemberData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getGroupSectionsById**
> OpenAPI\Server\Model\SectionData getGroupSectionsById($groupId)

Your GET endpoint

getGroupSectionsById

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
    public function getGroupSectionsById(int $groupId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **groupId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\SectionData**](../Model/SectionData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getGroups**
> OpenAPI\Server\Model\ScoutGroupData getGroups($sort, $pageSize, $page)

Get Groups

Get Groups

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
    public function getGroups(string $sort = null, int $pageSize = null, int $page = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **sort** | **string**|  | [optional]
 **pageSize** | **int**|  | [optional]
 **page** | **int**|  | [optional]

### Return type

[**OpenAPI\Server\Model\ScoutGroupData**](../Model/ScoutGroupData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **updateGroupById**
> OpenAPI\Server\Model\ScoutGroupData updateGroupById($groupId, $scoutGroupInput)

Update Group

Update Group

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
     * Implementation of GroupsApiInterface#updateGroupById
     */
    public function updateGroupById(int $groupId, ScoutGroupInput $scoutGroupInput = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **groupId** | **int**|  |
 **scoutGroupInput** | [**OpenAPI\Server\Model\ScoutGroupInput**](../Model/ScoutGroupInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\ScoutGroupData**](../Model/ScoutGroupData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

