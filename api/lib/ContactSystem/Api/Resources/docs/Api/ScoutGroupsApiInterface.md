# OpenAPI\Server\Api\ScoutGroupsApiInterface

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createScoutGroup**](ScoutGroupsApiInterface.md#createScoutGroup) | **POST** /groups | Create Group
[**deleteScoutGroupById**](ScoutGroupsApiInterface.md#deleteScoutGroupById) | **DELETE** /groups/{scoutGroupId} | Delete Group
[**getScoutGroupById**](ScoutGroupsApiInterface.md#getScoutGroupById) | **GET** /groups/{scoutGroupId} | Get Group
[**getScoutGroupSectionsById**](ScoutGroupsApiInterface.md#getScoutGroupSectionsById) | **GET** /groups/{scoutGroupId}/sections | Your GET endpoint
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

[contact_auth](../../README.md#contact_auth)

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

[contact_auth](../../README.md#contact_auth)

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

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getScoutGroupSectionsById**
> OpenAPI\Server\Model\Sections getScoutGroupSectionsById($scoutGroupId)

Your GET endpoint

getScoutGroupSectionsById

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
     * Implementation of ScoutGroupsApiInterface#getScoutGroupSectionsById
     */
    public function getScoutGroupSectionsById(int $scoutGroupId)
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

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getScoutGroups**
> OpenAPI\Server\Model\ScoutGroups getScoutGroups($sort, $pageSize, $page)

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
    public function getScoutGroups(string $sort = null, int $pageSize = null, int $page = null)
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

[**OpenAPI\Server\Model\ScoutGroups**](../Model/ScoutGroups.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

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

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

