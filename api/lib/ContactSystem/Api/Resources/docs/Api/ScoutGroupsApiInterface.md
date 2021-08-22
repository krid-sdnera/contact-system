# OpenAPI\Server\Api\ScoutGroupsApiInterface

All URIs are relative to *https://membership.essendonseascouts.org.au/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createScoutGroup**](ScoutGroupsApiInterface.md#createScoutGroup) | **POST** /groups | Create Group
[**deleteScoutGroupById**](ScoutGroupsApiInterface.md#deleteScoutGroupById) | **DELETE** /groups/{scoutGroupId} | Delete Group
[**getListRulesByScoutGroupId**](ScoutGroupsApiInterface.md#getListRulesByScoutGroupId) | **GET** /groups/{scoutGroupId}/list-rules | Get List Rules By Scout Group ID
[**getScoutGroupById**](ScoutGroupsApiInterface.md#getScoutGroupById) | **GET** /groups/{scoutGroupId} | Get Group
[**getScoutGroupSectionsByScoutGroupId**](ScoutGroupsApiInterface.md#getScoutGroupSectionsByScoutGroupId) | **GET** /groups/{scoutGroupId}/sections | Get Scout Group Sections By Scout Group ID
[**getScoutGroups**](ScoutGroupsApiInterface.md#getScoutGroups) | **GET** /groups | Get Groups
[**updateScoutGroupById**](ScoutGroupsApiInterface.md#updateScoutGroupById) | **PUT** /groups/{scoutGroupId} | Update Group


## Service Declaration
```yaml
# src/Acme/MyBundle/Resources/services.yml
services:
    # ...
    acme.my_bundle.api.scoutGroups:
        class: Acme\MyBundle\Api\ScoutGroupsApi
        tags:
            - { name: "open_api_server.api", api: "scoutGroups" }
    # ...
```

## **createScoutGroup**
> OpenAPI\Server\Model\ScoutGroupData createScoutGroup($scoutGroupInput)

Create Group

Create Group

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ScoutGroupsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ScoutGroupsApiInterface;

class ScoutGroupsApi implements ScoutGroupsApiInterface
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
     * Implementation of ScoutGroupsApiInterface#createScoutGroup
     */
    public function createScoutGroup(ScoutGroupInput $scoutGroupInput = null)
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

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **deleteScoutGroupById**
> OpenAPI\Server\Model\ApiResponse deleteScoutGroupById($scoutGroupId)

Delete Group

Delete Group

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ScoutGroupsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ScoutGroupsApiInterface;

class ScoutGroupsApi implements ScoutGroupsApiInterface
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
     * Implementation of ScoutGroupsApiInterface#deleteScoutGroupById
     */
    public function deleteScoutGroupById(int $scoutGroupId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **scoutGroupId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getListRulesByScoutGroupId**
> OpenAPI\Server\Model\ListRules getListRulesByScoutGroupId($scoutGroupId, $query, $sort, $pageSize, $page)

Get List Rules By Scout Group ID

Get List Rules By Scout Group ID

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ScoutGroupsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ScoutGroupsApiInterface;

class ScoutGroupsApi implements ScoutGroupsApiInterface
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
     * Implementation of ScoutGroupsApiInterface#getListRulesByScoutGroupId
     */
    public function getListRulesByScoutGroupId(int $scoutGroupId, string $query = null, string $sort = null, int $pageSize = null, int $page = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **scoutGroupId** | **int**|  |
 **query** | **string**|  | [optional]
 **sort** | **string**|  | [optional]
 **pageSize** | **int**|  | [optional]
 **page** | **int**|  | [optional]

### Return type

[**OpenAPI\Server\Model\ListRules**](../Model/ListRules.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getScoutGroupById**
> OpenAPI\Server\Model\ScoutGroupData getScoutGroupById($scoutGroupId)

Get Group

Get Group

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ScoutGroupsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ScoutGroupsApiInterface;

class ScoutGroupsApi implements ScoutGroupsApiInterface
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
     * Implementation of ScoutGroupsApiInterface#getScoutGroupById
     */
    public function getScoutGroupById(int $scoutGroupId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **scoutGroupId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\ScoutGroupData**](../Model/ScoutGroupData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getScoutGroupSectionsByScoutGroupId**
> OpenAPI\Server\Model\Sections getScoutGroupSectionsByScoutGroupId($scoutGroupId)

Get Scout Group Sections By Scout Group ID

Get Scout Group Sections By Scout Group ID

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ScoutGroupsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ScoutGroupsApiInterface;

class ScoutGroupsApi implements ScoutGroupsApiInterface
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
     * Implementation of ScoutGroupsApiInterface#getScoutGroupSectionsByScoutGroupId
     */
    public function getScoutGroupSectionsByScoutGroupId(int $scoutGroupId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **scoutGroupId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\Sections**](../Model/Sections.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getScoutGroups**
> OpenAPI\Server\Model\ScoutGroups getScoutGroups($query, $sort, $pageSize, $page)

Get Groups

Get Groups

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ScoutGroupsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ScoutGroupsApiInterface;

class ScoutGroupsApi implements ScoutGroupsApiInterface
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
     * Implementation of ScoutGroupsApiInterface#getScoutGroups
     */
    public function getScoutGroups(string $query = null, string $sort = null, int $pageSize = null, int $page = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **query** | **string**|  | [optional]
 **sort** | **string**|  | [optional]
 **pageSize** | **int**|  | [optional]
 **page** | **int**|  | [optional]

### Return type

[**OpenAPI\Server\Model\ScoutGroups**](../Model/ScoutGroups.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **updateScoutGroupById**
> OpenAPI\Server\Model\ScoutGroupData updateScoutGroupById($scoutGroupId, $scoutGroupInput)

Update Group

Update Group

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ScoutGroupsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ScoutGroupsApiInterface;

class ScoutGroupsApi implements ScoutGroupsApiInterface
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
     * Implementation of ScoutGroupsApiInterface#updateScoutGroupById
     */
    public function updateScoutGroupById(int $scoutGroupId, ScoutGroupInput $scoutGroupInput = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **scoutGroupId** | **int**|  |
 **scoutGroupInput** | [**OpenAPI\Server\Model\ScoutGroupInput**](../Model/ScoutGroupInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\ScoutGroupData**](../Model/ScoutGroupData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

