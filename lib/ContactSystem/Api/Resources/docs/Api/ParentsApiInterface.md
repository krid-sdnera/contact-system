# OpenAPI\Server\Api\ParentsApiInterface

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**deleteGroupsGroupId**](ParentsApiInterface.md#deleteGroupsGroupId) | **DELETE** /groups/{groupId} | 
[**deleteParentsParentId**](ParentsApiInterface.md#deleteParentsParentId) | **DELETE** /parents/{parentId} | 
[**getGroupsGroupId**](ParentsApiInterface.md#getGroupsGroupId) | **GET** /groups/{groupId} | Your GET endpoint
[**getParents**](ParentsApiInterface.md#getParents) | **GET** /parents | Your GET endpoint
[**getParentsParentId**](ParentsApiInterface.md#getParentsParentId) | **GET** /parents/{parentId} | Your GET endpoint
[**getParentsParentIdMembers**](ParentsApiInterface.md#getParentsParentIdMembers) | **GET** /parents/{parentId}/members | Your GET endpoint
[**postParents**](ParentsApiInterface.md#postParents) | **POST** /parents | 
[**putGroupsGroupId**](ParentsApiInterface.md#putGroupsGroupId) | **PUT** /groups/{groupId} | 
[**putParentsParentId**](ParentsApiInterface.md#putParentsParentId) | **PUT** /parents/{parentId} | 


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

## **deleteGroupsGroupId**
> OpenAPI\Server\Model\ApiResponse deleteGroupsGroupId($groupId)



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
     * Implementation of ParentsApiInterface#deleteGroupsGroupId
     */
    public function deleteGroupsGroupId($groupId)
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

## **deleteParentsParentId**
> OpenAPI\Server\Model\ApiResponse deleteParentsParentId($parentId)



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
     * Implementation of ParentsApiInterface#deleteParentsParentId
     */
    public function deleteParentsParentId($parentId)
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

## **getGroupsGroupId**
> OpenAPI\Server\Model\Group getGroupsGroupId($groupId)

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
     * Implementation of ParentsApiInterface#getGroupsGroupId
     */
    public function getGroupsGroupId($groupId)
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

[**OpenAPI\Server\Model\Group**](../Model/Group.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getParents**
> OpenAPI\Server\Model\MemberParent getParents()

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

[**OpenAPI\Server\Model\MemberParent**](../Model/MemberParent.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getParentsParentId**
> OpenAPI\Server\Model\MemberParent getParentsParentId($parentId)

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
     * Implementation of ParentsApiInterface#getParentsParentId
     */
    public function getParentsParentId($parentId)
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

[**OpenAPI\Server\Model\MemberParent**](../Model/MemberParent.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getParentsParentIdMembers**
> string getParentsParentIdMembers($parentId)

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
     * Implementation of ParentsApiInterface#getParentsParentIdMembers
     */
    public function getParentsParentIdMembers($parentId)
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

**string**

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **postParents**
> OpenAPI\Server\Model\MemberParent postParents($memberParent)



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
     * Implementation of ParentsApiInterface#postParents
     */
    public function postParents(MemberParent $memberParent = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberParent** | [**OpenAPI\Server\Model\MemberParent**](../Model/MemberParent.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\MemberParent**](../Model/MemberParent.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **putGroupsGroupId**
> OpenAPI\Server\Model\Group putGroupsGroupId($groupId, $group)



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
     * Implementation of ParentsApiInterface#putGroupsGroupId
     */
    public function putGroupsGroupId($groupId, Group $group = null)
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
 **group** | [**OpenAPI\Server\Model\Group**](../Model/Group.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\Group**](../Model/Group.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **putParentsParentId**
> OpenAPI\Server\Model\MemberParent putParentsParentId($parentId, $memberParent)



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
     * Implementation of ParentsApiInterface#putParentsParentId
     */
    public function putParentsParentId($parentId, MemberParent $memberParent = null)
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
 **memberParent** | [**OpenAPI\Server\Model\MemberParent**](../Model/MemberParent.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\MemberParent**](../Model/MemberParent.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

