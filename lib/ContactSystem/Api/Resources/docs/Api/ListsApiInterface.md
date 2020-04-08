# OpenAPI\Server\Api\ListsApiInterface

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**deleteListsListId**](ListsApiInterface.md#deleteListsListId) | **DELETE** /lists/{listId} | 
[**deleteListsListIdRulesRuleId**](ListsApiInterface.md#deleteListsListIdRulesRuleId) | **DELETE** /lists/{listId}/rules/{ruleId} | 
[**deleteListsTypesListTypeId**](ListsApiInterface.md#deleteListsTypesListTypeId) | **DELETE** /lists/types/{listTypeId} | 
[**getLists**](ListsApiInterface.md#getLists) | **GET** /lists | Your GET endpoint
[**getListsListId**](ListsApiInterface.md#getListsListId) | **GET** /lists/{listId} | Your GET endpoint
[**getListsListIdMembers**](ListsApiInterface.md#getListsListIdMembers) | **GET** /lists/{listId}/members | Your GET endpoint
[**getListsListIdRules**](ListsApiInterface.md#getListsListIdRules) | **GET** /lists/{listId}/rules | Your GET endpoint
[**getListsListIdRulesRuleId**](ListsApiInterface.md#getListsListIdRulesRuleId) | **GET** /lists/{listId}/rules/{ruleId} | Your GET endpoint
[**getListsTypes**](ListsApiInterface.md#getListsTypes) | **GET** /lists/types | Your GET endpoint
[**getListsTypesListTypeId**](ListsApiInterface.md#getListsTypesListTypeId) | **GET** /lists/types/{listTypeId} | Your GET endpoint
[**postLists**](ListsApiInterface.md#postLists) | **POST** /lists | 
[**postListsListIdRules**](ListsApiInterface.md#postListsListIdRules) | **POST** /lists/{listId}/rules | 
[**postListsTypes**](ListsApiInterface.md#postListsTypes) | **POST** /lists/types | 
[**putListsListId**](ListsApiInterface.md#putListsListId) | **PUT** /lists/{listId} | 
[**putListsListIdRulesRuleId**](ListsApiInterface.md#putListsListIdRulesRuleId) | **PUT** /lists/{listId}/rules/{ruleId} | 
[**putListsTypesListTypeId**](ListsApiInterface.md#putListsTypesListTypeId) | **PUT** /lists/types/{listTypeId} | 


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

## **deleteListsListId**
> OpenAPI\Server\Model\ApiResponse deleteListsListId($listId)



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
     * Implementation of ListsApiInterface#deleteListsListId
     */
    public function deleteListsListId($listId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **deleteListsListIdRulesRuleId**
> OpenAPI\Server\Model\ApiResponse deleteListsListIdRulesRuleId($listId, $ruleId)



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
     * Implementation of ListsApiInterface#deleteListsListIdRulesRuleId
     */
    public function deleteListsListIdRulesRuleId($listId, $ruleId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listId** | **string**|  |
 **ruleId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **deleteListsTypesListTypeId**
> OpenAPI\Server\Model\ApiResponse deleteListsTypesListTypeId($listTypeId)



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
     * Implementation of ListsApiInterface#deleteListsTypesListTypeId
     */
    public function deleteListsTypesListTypeId($listTypeId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listTypeId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getLists**
> OpenAPI\Server\Model\ModelList getLists()

Your GET endpoint

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
    public function getLists()
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**OpenAPI\Server\Model\ModelList**](../Model/ModelList.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getListsListId**
> OpenAPI\Server\Model\ModelList getListsListId($listId)

Your GET endpoint

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
     * Implementation of ListsApiInterface#getListsListId
     */
    public function getListsListId($listId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ModelList**](../Model/ModelList.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getListsListIdMembers**
> string getListsListIdMembers($listId)

Your GET endpoint

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
     * Implementation of ListsApiInterface#getListsListIdMembers
     */
    public function getListsListIdMembers($listId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listId** | **string**|  |

### Return type

**string**

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getListsListIdRules**
> OpenAPI\Server\Model\ListRule getListsListIdRules($listId)

Your GET endpoint

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
     * Implementation of ListsApiInterface#getListsListIdRules
     */
    public function getListsListIdRules($listId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ListRule**](../Model/ListRule.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getListsListIdRulesRuleId**
> OpenAPI\Server\Model\ListRule getListsListIdRulesRuleId($listId, $ruleId)

Your GET endpoint

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
     * Implementation of ListsApiInterface#getListsListIdRulesRuleId
     */
    public function getListsListIdRulesRuleId($listId, $ruleId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listId** | **string**|  |
 **ruleId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ListRule**](../Model/ListRule.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getListsTypes**
> OpenAPI\Server\Model\ListType getListsTypes()

Your GET endpoint

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
     * Implementation of ListsApiInterface#getListsTypes
     */
    public function getListsTypes()
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**OpenAPI\Server\Model\ListType**](../Model/ListType.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getListsTypesListTypeId**
> OpenAPI\Server\Model\ListType getListsTypesListTypeId($listTypeId)

Your GET endpoint

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
     * Implementation of ListsApiInterface#getListsTypesListTypeId
     */
    public function getListsTypesListTypeId($listTypeId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listTypeId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ListType**](../Model/ListType.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **postLists**
> OpenAPI\Server\Model\ModelList postLists($modelList)



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
     * Implementation of ListsApiInterface#postLists
     */
    public function postLists(ModelList $modelList = null)
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

## **postListsListIdRules**
> OpenAPI\Server\Model\ListRule postListsListIdRules($listId, $listRule)



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
     * Implementation of ListsApiInterface#postListsListIdRules
     */
    public function postListsListIdRules($listId, ListRule $listRule = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listId** | **string**|  |
 **listRule** | [**OpenAPI\Server\Model\ListRule**](../Model/ListRule.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\ListRule**](../Model/ListRule.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **postListsTypes**
> OpenAPI\Server\Model\ListType postListsTypes($listType)



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
     * Implementation of ListsApiInterface#postListsTypes
     */
    public function postListsTypes(ListType $listType = null)
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

## **putListsListId**
> OpenAPI\Server\Model\ModelList putListsListId($listId, $modelList)



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
     * Implementation of ListsApiInterface#putListsListId
     */
    public function putListsListId($listId, ModelList $modelList = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listId** | **string**|  |
 **modelList** | [**OpenAPI\Server\Model\ModelList**](../Model/ModelList.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\ModelList**](../Model/ModelList.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **putListsListIdRulesRuleId**
> OpenAPI\Server\Model\ListRule putListsListIdRulesRuleId($listId, $ruleId, $listRule)



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
     * Implementation of ListsApiInterface#putListsListIdRulesRuleId
     */
    public function putListsListIdRulesRuleId($listId, $ruleId, ListRule $listRule = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listId** | **string**|  |
 **ruleId** | **string**|  |
 **listRule** | [**OpenAPI\Server\Model\ListRule**](../Model/ListRule.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\ListRule**](../Model/ListRule.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **putListsTypesListTypeId**
> OpenAPI\Server\Model\ListType putListsTypesListTypeId($listTypeId, $listType)



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
     * Implementation of ListsApiInterface#putListsTypesListTypeId
     */
    public function putListsTypesListTypeId($listTypeId, ListType $listType = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **listTypeId** | **string**|  |
 **listType** | [**OpenAPI\Server\Model\ListType**](../Model/ListType.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\ListType**](../Model/ListType.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

