# OpenAPI\Server\Api\RolesApiInterface

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**deleteRolesCustomCustomRoleId**](RolesApiInterface.md#deleteRolesCustomCustomRoleId) | **DELETE** /roles/custom/{customRoleId} | 
[**getRolesCustom**](RolesApiInterface.md#getRolesCustom) | **GET** /roles/custom | Your GET endpoint
[**getRolesCustomCustomRoleId**](RolesApiInterface.md#getRolesCustomCustomRoleId) | **GET** /roles/custom/{customRoleId} | Your GET endpoint
[**getRolesCustomCustomRoleIdMembers**](RolesApiInterface.md#getRolesCustomCustomRoleIdMembers) | **GET** /roles/custom/{customRoleId}/members | Your GET endpoint
[**postRolesCustom**](RolesApiInterface.md#postRolesCustom) | **POST** /roles/custom | 
[**putRolesCustomCustomRoleId**](RolesApiInterface.md#putRolesCustomCustomRoleId) | **PUT** /roles/custom/{customRoleId} | 


## Service Declaration
```yaml
# src/Acme/MyBundle/Resources/services.yml
services:
    # ...
    acme.my_bundle.api.roles:
        class: Acme\MyBundle\Api\RolesApi
        tags:
            - { name: "open_api_server.api", api: "roles" }
    # ...
```

## **deleteRolesCustomCustomRoleId**
> OpenAPI\Server\Model\ApiResponse deleteRolesCustomCustomRoleId($customRoleId)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/RolesApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\RolesApiInterface;

class RolesApi implements RolesApiInterface
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
     * Implementation of RolesApiInterface#deleteRolesCustomCustomRoleId
     */
    public function deleteRolesCustomCustomRoleId($customRoleId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **customRoleId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getRolesCustom**
> OpenAPI\Server\Model\Role getRolesCustom()

Your GET endpoint

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/RolesApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\RolesApiInterface;

class RolesApi implements RolesApiInterface
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
     * Implementation of RolesApiInterface#getRolesCustom
     */
    public function getRolesCustom()
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**OpenAPI\Server\Model\Role**](../Model/Role.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getRolesCustomCustomRoleId**
> OpenAPI\Server\Model\Role getRolesCustomCustomRoleId($customRoleId)

Your GET endpoint

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/RolesApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\RolesApiInterface;

class RolesApi implements RolesApiInterface
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
     * Implementation of RolesApiInterface#getRolesCustomCustomRoleId
     */
    public function getRolesCustomCustomRoleId($customRoleId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **customRoleId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\Role**](../Model/Role.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getRolesCustomCustomRoleIdMembers**
> string getRolesCustomCustomRoleIdMembers($customRoleId)

Your GET endpoint

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/RolesApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\RolesApiInterface;

class RolesApi implements RolesApiInterface
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
     * Implementation of RolesApiInterface#getRolesCustomCustomRoleIdMembers
     */
    public function getRolesCustomCustomRoleIdMembers($customRoleId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **customRoleId** | **string**|  |

### Return type

**string**

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **postRolesCustom**
> OpenAPI\Server\Model\Role postRolesCustom($role)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/RolesApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\RolesApiInterface;

class RolesApi implements RolesApiInterface
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
     * Implementation of RolesApiInterface#postRolesCustom
     */
    public function postRolesCustom(Role $role = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **role** | [**OpenAPI\Server\Model\Role**](../Model/Role.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\Role**](../Model/Role.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **putRolesCustomCustomRoleId**
> OpenAPI\Server\Model\Role putRolesCustomCustomRoleId($customRoleId, $role)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/RolesApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\RolesApiInterface;

class RolesApi implements RolesApiInterface
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
     * Implementation of RolesApiInterface#putRolesCustomCustomRoleId
     */
    public function putRolesCustomCustomRoleId($customRoleId, Role $role = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **customRoleId** | **string**|  |
 **role** | [**OpenAPI\Server\Model\Role**](../Model/Role.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\Role**](../Model/Role.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

