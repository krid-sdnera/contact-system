# OpenAPI\Server\Api\ListsApiInterface

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createList**](ListsApiInterface.md#createList) | **POST** /lists | 
[**createListRuleById**](ListsApiInterface.md#createListRuleById) | **POST** /lists/{listId}/rules | 
[**createListTypes**](ListsApiInterface.md#createListTypes) | **POST** /lists/types | 
[**deleteListById**](ListsApiInterface.md#deleteListById) | **DELETE** /lists/{listId} | 
[**deleteListRuleById**](ListsApiInterface.md#deleteListRuleById) | **DELETE** /lists/{listId}/rules/{ruleId} | 
[**deleteListTypeById**](ListsApiInterface.md#deleteListTypeById) | **DELETE** /lists/types/{listTypeId} | 
[**getListById**](ListsApiInterface.md#getListById) | **GET** /lists/{listId} | Your GET endpoint
[**getListMembersById**](ListsApiInterface.md#getListMembersById) | **GET** /lists/{listId}/members | Your GET endpoint
[**getListRuleById**](ListsApiInterface.md#getListRuleById) | **GET** /lists/{listId}/rules/{ruleId} | Your GET endpoint
[**getListRulesById**](ListsApiInterface.md#getListRulesById) | **GET** /lists/{listId}/rules | Your GET endpoint
[**getListTypeById**](ListsApiInterface.md#getListTypeById) | **GET** /lists/types/{listTypeId} | Your GET endpoint
[**getListTypes**](ListsApiInterface.md#getListTypes) | **GET** /lists/types | Your GET endpoint
[**getLists**](ListsApiInterface.md#getLists) | **GET** /lists | Your GET endpoint
[**updateListById**](ListsApiInterface.md#updateListById) | **PUT** /lists/{listId} | 
[**updateListRuleById**](ListsApiInterface.md#updateListRuleById) | **PUT** /lists/{listId}/rules/{ruleId} | 
[**updateListTypeById**](ListsApiInterface.md#updateListTypeById) | **PUT** /lists/types/{listTypeId} | 


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
> OpenAPI\Server\Model\ModelList createList($modelList)



createList

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
    public function createList(ModelList $modelList = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **modelList** | [**OpenAPI\Server\Model\ModelList**](../Model/ModelList.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\ModelList**](../Model/ModelList.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **createListRuleById**
> OpenAPI\Server\Model\ListRule createListRuleById($listId, $listRule)



createListRuleById

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
     * Implementation of ListsApiInterface#createListRuleById
     */
    public function createListRuleById(int $listId, ListRule $listRule = null)
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
 **listRule** | [**OpenAPI\Server\Model\ListRule**](../Model/ListRule.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\ListRule**](../Model/ListRule.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **createListTypes**
> OpenAPI\Server\Model\ListType createListTypes($listType)



createListTypes

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
     * Implementation of ListsApiInterface#createListTypes
     */
    public function createListTypes(ListType $listType = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listType** | [**OpenAPI\Server\Model\ListType**](../Model/ListType.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\ListType**](../Model/ListType.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **deleteListById**
> OpenAPI\Server\Model\ApiResponse deleteListById($listId)



deleteListById

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

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **deleteListRuleById**
> OpenAPI\Server\Model\ApiResponse deleteListRuleById($listId, $ruleId)



deleteListRuleById

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
     * Implementation of ListsApiInterface#deleteListRuleById
     */
    public function deleteListRuleById(int $listId, int $ruleId)
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

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **deleteListTypeById**
> OpenAPI\Server\Model\ApiResponse deleteListTypeById($listTypeId)



deleteListTypeById

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
     * Implementation of ListsApiInterface#deleteListTypeById
     */
    public function deleteListTypeById(int $listTypeId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listTypeId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getListById**
> OpenAPI\Server\Model\ModelList getListById($listId)

Your GET endpoint

getListById

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

[**OpenAPI\Server\Model\ModelList**](../Model/ModelList.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getListMembersById**
> OpenAPI\Server\Model\MemberData getListMembersById($listId)

Your GET endpoint

getListMembersById

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
     * Implementation of ListsApiInterface#getListMembersById
     */
    public function getListMembersById(int $listId)
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

[**OpenAPI\Server\Model\MemberData**](../Model/MemberData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getListRuleById**
> OpenAPI\Server\Model\ListRule getListRuleById($listId, $ruleId)

Your GET endpoint

getListRuleById

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
     * Implementation of ListsApiInterface#getListRuleById
     */
    public function getListRuleById(int $listId, int $ruleId)
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

[**OpenAPI\Server\Model\ListRule**](../Model/ListRule.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getListRulesById**
> OpenAPI\Server\Model\ListRule getListRulesById($listId)

Your GET endpoint

getListRulesById

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
     * Implementation of ListsApiInterface#getListRulesById
     */
    public function getListRulesById(int $listId)
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

[**OpenAPI\Server\Model\ListRule**](../Model/ListRule.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getListTypeById**
> OpenAPI\Server\Model\ListType getListTypeById($listTypeId)

Your GET endpoint

getListTypeById

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
     * Implementation of ListsApiInterface#getListTypeById
     */
    public function getListTypeById(int $listTypeId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listTypeId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\ListType**](../Model/ListType.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getListTypes**
> OpenAPI\Server\Model\ListType getListTypes($sort, $pageSize, $page)

Your GET endpoint

getListTypes

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
     * Implementation of ListsApiInterface#getListTypes
     */
    public function getListTypes(string $sort = null, int $pageSize = null, int $page = null)
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

[**OpenAPI\Server\Model\ListType**](../Model/ListType.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getLists**
> OpenAPI\Server\Model\ModelList getLists($sort, $pageSize, $page)

Your GET endpoint

getLists

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
    public function getLists(string $sort = null, int $pageSize = null, int $page = null)
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

[**OpenAPI\Server\Model\ModelList**](../Model/ModelList.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **updateListById**
> OpenAPI\Server\Model\ModelList updateListById($listId, $modelList)



updateListById

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
    public function updateListById(int $listId, ModelList $modelList = null)
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
 **modelList** | [**OpenAPI\Server\Model\ModelList**](../Model/ModelList.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\ModelList**](../Model/ModelList.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **updateListRuleById**
> OpenAPI\Server\Model\ListRule updateListRuleById($listId, $ruleId, $listRule)



updateListRuleById

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
     * Implementation of ListsApiInterface#updateListRuleById
     */
    public function updateListRuleById(int $listId, int $ruleId, ListRule $listRule = null)
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
 **listRule** | [**OpenAPI\Server\Model\ListRule**](../Model/ListRule.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\ListRule**](../Model/ListRule.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **updateListTypeById**
> OpenAPI\Server\Model\ListType updateListTypeById($listTypeId, $listType)



updateListTypeById

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
     * Implementation of ListsApiInterface#updateListTypeById
     */
    public function updateListTypeById(int $listTypeId, ListType $listType = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listTypeId** | **int**|  |
 **listType** | [**OpenAPI\Server\Model\ListType**](../Model/ListType.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\ListType**](../Model/ListType.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

