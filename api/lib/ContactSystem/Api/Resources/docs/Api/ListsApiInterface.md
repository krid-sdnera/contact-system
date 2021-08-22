# OpenAPI\Server\Api\ListsApiInterface

All URIs are relative to *https://membership.essendonseascouts.org.au/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createList**](ListsApiInterface.md#createList) | **POST** /lists | Create List
[**createListRuleByListId**](ListsApiInterface.md#createListRuleByListId) | **POST** /lists/{listId}/list-rules | Create List Rule By List ID
[**deleteListById**](ListsApiInterface.md#deleteListById) | **DELETE** /lists/{listId} | Delete List By ID
[**deleteListRuleByListId**](ListsApiInterface.md#deleteListRuleByListId) | **DELETE** /lists/{listId}/rules/{ruleId} | Delete List Rule By List ID
[**getListByAddress**](ListsApiInterface.md#getListByAddress) | **GET** /lists/address/{listAddress} | Get List By Address
[**getListById**](ListsApiInterface.md#getListById) | **GET** /lists/{listId} | Get List By ID
[**getListRecipientsByListId**](ListsApiInterface.md#getListRecipientsByListId) | **GET** /lists/{listId}/recipients | Get List Recipients By List ID
[**getListRuleByListId**](ListsApiInterface.md#getListRuleByListId) | **GET** /lists/{listId}/rules/{ruleId} | Get List Rule By List ID
[**getListRulesByListId**](ListsApiInterface.md#getListRulesByListId) | **GET** /lists/{listId}/list-rules | Get List Rules By List ID
[**getLists**](ListsApiInterface.md#getLists) | **GET** /lists | Get Lists
[**updateListById**](ListsApiInterface.md#updateListById) | **PUT** /lists/{listId} | Update List By ID
[**updateListRuleByListId**](ListsApiInterface.md#updateListRuleByListId) | **PUT** /lists/{listId}/rules/{ruleId} | Update List Rule By List ID


## Service Declaration
```yaml
# src/Acme/MyBundle/Resources/services.yml
services:
    # ...
    acme.my_bundle.api.lists:
        class: Acme\MyBundle\Api\ListsApi
        tags:
            - { name: "open_api_server.api", api: "lists" }
    # ...
```

## **createList**
> OpenAPI\Server\Model\ListData createList($listInput)

Create List

Create List

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ListsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ListsApiInterface;

class ListsApi implements ListsApiInterface
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
     * Implementation of ListsApiInterface#createList
     */
    public function createList(ListInput $listInput = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listInput** | [**OpenAPI\Server\Model\ListInput**](../Model/ListInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\ListData**](../Model/ListData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **createListRuleByListId**
> OpenAPI\Server\Model\ListRuleData createListRuleByListId($listId, $listRuleInput)

Create List Rule By List ID

Create List Rule By List ID

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ListsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ListsApiInterface;

class ListsApi implements ListsApiInterface
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
     * Implementation of ListsApiInterface#createListRuleByListId
     */
    public function createListRuleByListId(int $listId, ListRuleInput $listRuleInput = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listId** | **int**|  |
 **listRuleInput** | [**OpenAPI\Server\Model\ListRuleInput**](../Model/ListRuleInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\ListRuleData**](../Model/ListRuleData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **deleteListById**
> OpenAPI\Server\Model\ApiResponse deleteListById($listId)

Delete List By ID

Delete List By ID

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ListsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ListsApiInterface;

class ListsApi implements ListsApiInterface
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
     * Implementation of ListsApiInterface#deleteListById
     */
    public function deleteListById(int $listId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **deleteListRuleByListId**
> OpenAPI\Server\Model\ApiResponse deleteListRuleByListId($listId, $ruleId)

Delete List Rule By List ID

Delete List Rule By List ID

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ListsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ListsApiInterface;

class ListsApi implements ListsApiInterface
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
     * Implementation of ListsApiInterface#deleteListRuleByListId
     */
    public function deleteListRuleByListId(int $listId, int $ruleId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listId** | **int**|  |
 **ruleId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getListByAddress**
> OpenAPI\Server\Model\ListData getListByAddress($listAddress)

Get List By Address

Get List By Address

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ListsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ListsApiInterface;

class ListsApi implements ListsApiInterface
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
     * Implementation of ListsApiInterface#getListByAddress
     */
    public function getListByAddress(string $listAddress)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listAddress** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ListData**](../Model/ListData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getListById**
> OpenAPI\Server\Model\ListData getListById($listId)

Get List By ID

Get List By ID

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ListsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ListsApiInterface;

class ListsApi implements ListsApiInterface
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
     * Implementation of ListsApiInterface#getListById
     */
    public function getListById(int $listId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\ListData**](../Model/ListData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getListRecipientsByListId**
> OpenAPI\Server\Model\Recipients getListRecipientsByListId($listId, $query, $sort, $pageSize, $page)

Get List Recipients By List ID

Get List Recipients By List ID

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ListsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ListsApiInterface;

class ListsApi implements ListsApiInterface
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
     * Implementation of ListsApiInterface#getListRecipientsByListId
     */
    public function getListRecipientsByListId(int $listId, string $query = null, string $sort = null, int $pageSize = null, int $page = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listId** | **int**|  |
 **query** | **string**|  | [optional]
 **sort** | **string**|  | [optional]
 **pageSize** | **int**|  | [optional]
 **page** | **int**|  | [optional]

### Return type

[**OpenAPI\Server\Model\Recipients**](../Model/Recipients.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getListRuleByListId**
> OpenAPI\Server\Model\ListRuleData getListRuleByListId($listId, $ruleId)

Get List Rule By List ID

Get List Rule By List ID

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ListsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ListsApiInterface;

class ListsApi implements ListsApiInterface
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
     * Implementation of ListsApiInterface#getListRuleByListId
     */
    public function getListRuleByListId(int $listId, int $ruleId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listId** | **int**|  |
 **ruleId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\ListRuleData**](../Model/ListRuleData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getListRulesByListId**
> OpenAPI\Server\Model\ListRules getListRulesByListId($listId, $query, $sort, $pageSize, $page)

Get List Rules By List ID

Get List Rule By List ID

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ListsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ListsApiInterface;

class ListsApi implements ListsApiInterface
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
     * Implementation of ListsApiInterface#getListRulesByListId
     */
    public function getListRulesByListId(int $listId, string $query = null, string $sort = null, int $pageSize = null, int $page = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listId** | **int**|  |
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

## **getLists**
> OpenAPI\Server\Model\Lists getLists($query, $sort, $pageSize, $page)

Get Lists

Get Lists

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ListsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ListsApiInterface;

class ListsApi implements ListsApiInterface
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
     * Implementation of ListsApiInterface#getLists
     */
    public function getLists(string $query = null, string $sort = null, int $pageSize = null, int $page = null)
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

[**OpenAPI\Server\Model\Lists**](../Model/Lists.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **updateListById**
> OpenAPI\Server\Model\ListData updateListById($listId, $listInput)

Update List By ID

Update List By ID

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ListsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ListsApiInterface;

class ListsApi implements ListsApiInterface
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
     * Implementation of ListsApiInterface#updateListById
     */
    public function updateListById(int $listId, ListInput $listInput = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listId** | **int**|  |
 **listInput** | [**OpenAPI\Server\Model\ListInput**](../Model/ListInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\ListData**](../Model/ListData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **updateListRuleByListId**
> OpenAPI\Server\Model\ListRuleData updateListRuleByListId($listId, $ruleId, $listRuleInput)

Update List Rule By List ID

Update List Rule By List ID

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ListsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ListsApiInterface;

class ListsApi implements ListsApiInterface
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
     * Implementation of ListsApiInterface#updateListRuleByListId
     */
    public function updateListRuleByListId(int $listId, int $ruleId, ListRuleInput $listRuleInput = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listId** | **int**|  |
 **ruleId** | **int**|  |
 **listRuleInput** | [**OpenAPI\Server\Model\ListRuleInput**](../Model/ListRuleInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\ListRuleData**](../Model/ListRuleData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

