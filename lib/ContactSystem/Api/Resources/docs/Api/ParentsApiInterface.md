# OpenAPI\Server\Api\ParentsApiInterface

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createParent**](ParentsApiInterface.md#createParent) | **POST** /parents | 
[**deleteGroupById**](ParentsApiInterface.md#deleteGroupById) | **DELETE** /groups/{groupId} | 
[**deleteParentById**](ParentsApiInterface.md#deleteParentById) | **DELETE** /parents/{parentId} | 
[**getGroupById**](ParentsApiInterface.md#getGroupById) | **GET** /groups/{groupId} | Your GET endpoint
[**getParentById**](ParentsApiInterface.md#getParentById) | **GET** /parents/{parentId} | Your GET endpoint
[**getParentMembersById**](ParentsApiInterface.md#getParentMembersById) | **GET** /parents/{parentId}/members | Your GET endpoint
[**getParents**](ParentsApiInterface.md#getParents) | **GET** /parents | Your GET endpoint
[**updateGroupById**](ParentsApiInterface.md#updateGroupById) | **PUT** /groups/{groupId} | 
[**updateParentById**](ParentsApiInterface.md#updateParentById) | **PUT** /parents/{parentId} | 


## Service Declaration
```yaml
# src/Acme/MyBundle/Resources/services.yml
services:
    # ...
    acme.my_bundle.api.parents:
        class: Acme\MyBundle\Api\ParentsApi
        tags:
            - { name: "open_api_server.api", api: "parents" }
    # ...
```

## **createParent**
> OpenAPI\Server\Model\MemberParentData createParent($memberParentInput)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ParentsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ParentsApiInterface;

class ParentsApi implements ParentsApiInterface
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
     * Implementation of ParentsApiInterface#createParent
     */
    public function createParent(MemberParentInput $memberParentInput = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberParentInput** | [**OpenAPI\Server\Model\MemberParentInput**](../Model/MemberParentInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\MemberParentData**](../Model/MemberParentData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **deleteGroupById**
> OpenAPI\Server\Model\ApiResponse deleteGroupById($groupId)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ParentsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ParentsApiInterface;

class ParentsApi implements ParentsApiInterface
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
     * Implementation of ParentsApiInterface#deleteGroupById
     */
    public function deleteGroupById($groupId)
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

## **deleteParentById**
> OpenAPI\Server\Model\ApiResponse deleteParentById($parentId)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ParentsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ParentsApiInterface;

class ParentsApi implements ParentsApiInterface
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
     * Implementation of ParentsApiInterface#deleteParentById
     */
    public function deleteParentById($parentId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **parentId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getGroupById**
> OpenAPI\Server\Model\GroupData getGroupById($groupId)

Your GET endpoint

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ParentsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ParentsApiInterface;

class ParentsApi implements ParentsApiInterface
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
     * Implementation of ParentsApiInterface#getGroupById
     */
    public function getGroupById($groupId)
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

[**OpenAPI\Server\Model\GroupData**](../Model/GroupData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getParentById**
> OpenAPI\Server\Model\MemberParentData getParentById($parentId)

Your GET endpoint

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ParentsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ParentsApiInterface;

class ParentsApi implements ParentsApiInterface
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
     * Implementation of ParentsApiInterface#getParentById
     */
    public function getParentById($parentId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **parentId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\MemberParentData**](../Model/MemberParentData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getParentMembersById**
> OpenAPI\Server\Model\MemberData getParentMembersById($parentId)

Your GET endpoint

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ParentsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ParentsApiInterface;

class ParentsApi implements ParentsApiInterface
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
     * Implementation of ParentsApiInterface#getParentMembersById
     */
    public function getParentMembersById($parentId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **parentId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\MemberData**](../Model/MemberData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getParents**
> OpenAPI\Server\Model\MemberParentData getParents()

Your GET endpoint

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ParentsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ParentsApiInterface;

class ParentsApi implements ParentsApiInterface
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
     * Implementation of ParentsApiInterface#getParents
     */
    public function getParents()
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**OpenAPI\Server\Model\MemberParentData**](../Model/MemberParentData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **updateGroupById**
> OpenAPI\Server\Model\GroupData updateGroupById($groupId, $groupInput)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ParentsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ParentsApiInterface;

class ParentsApi implements ParentsApiInterface
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
     * Implementation of ParentsApiInterface#updateGroupById
     */
    public function updateGroupById($groupId, GroupInput $groupInput = null)
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
 **groupInput** | [**OpenAPI\Server\Model\GroupInput**](../Model/GroupInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\GroupData**](../Model/GroupData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **updateParentById**
> OpenAPI\Server\Model\MemberParentData updateParentById($parentId, $memberParentInput)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ParentsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ParentsApiInterface;

class ParentsApi implements ParentsApiInterface
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
     * Implementation of ParentsApiInterface#updateParentById
     */
    public function updateParentById($parentId, MemberParentInput $memberParentInput = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **parentId** | **string**|  |
 **memberParentInput** | [**OpenAPI\Server\Model\MemberParentInput**](../Model/MemberParentInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\MemberParentData**](../Model/MemberParentData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

