# OpenAPI\Server\Api\RolesApiInterface

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createRole**](RolesApiInterface.md#createRole) | **POST** /roles | Create role
[**deleteRoleById**](RolesApiInterface.md#deleteRoleById) | **DELETE** /roles/{roleId} | Delete role
[**getMembersByRoleId**](RolesApiInterface.md#getMembersByRoleId) | **GET** /roles/{roleId}/members | List members by role
[**getRoleById**](RolesApiInterface.md#getRoleById) | **GET** /roles/{roleId} | Get Role
[**getRoles**](RolesApiInterface.md#getRoles) | **GET** /roles | Get roles
[**updateRoleById**](RolesApiInterface.md#updateRoleById) | **PUT** /roles/{roleId} | Update role


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

## **createRole**
> OpenAPI\Server\Model\RoleData createRole($roleInput)

Create role

Create role

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
     * Implementation of RolesApiInterface#createRole
     */
    public function createRole(RoleInput $roleInput = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **roleInput** | [**OpenAPI\Server\Model\RoleInput**](../Model/RoleInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\RoleData**](../Model/RoleData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **deleteRoleById**
> OpenAPI\Server\Model\ApiResponse deleteRoleById($roleId)

Delete role

Delete role

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
     * Implementation of RolesApiInterface#deleteRoleById
     */
    public function deleteRoleById(int $roleId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **roleId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getMembersByRoleId**
> OpenAPI\Server\Model\Members getMembersByRoleId($roleId, $query, $sort, $pageSize, $page)

List members by role

List all members in this role

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
     * Implementation of RolesApiInterface#getMembersByRoleId
     */
    public function getMembersByRoleId(int $roleId, string $query = null, string $sort = null, int $pageSize = null, int $page = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **roleId** | **int**|  |
 **query** | **string**|  | [optional]
 **sort** | **string**|  | [optional]
 **pageSize** | **int**|  | [optional]
 **page** | **int**|  | [optional]

### Return type

[**OpenAPI\Server\Model\Members**](../Model/Members.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getRoleById**
> OpenAPI\Server\Model\RoleData getRoleById($roleId)

Get Role

Get role

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
     * Implementation of RolesApiInterface#getRoleById
     */
    public function getRoleById(int $roleId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **roleId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\RoleData**](../Model/RoleData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getRoles**
> OpenAPI\Server\Model\Roles getRoles($query, $sort, $pageSize, $page)

Get roles

Get roles

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
     * Implementation of RolesApiInterface#getRoles
     */
    public function getRoles(string $query = null, string $sort = null, int $pageSize = null, int $page = null)
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

[**OpenAPI\Server\Model\Roles**](../Model/Roles.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **updateRoleById**
> OpenAPI\Server\Model\RoleData updateRoleById($roleId, $roleInput)

Update role

Update role

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
     * Implementation of RolesApiInterface#updateRoleById
     */
    public function updateRoleById(int $roleId, RoleInput $roleInput = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **roleId** | **int**|  |
 **roleInput** | [**OpenAPI\Server\Model\RoleInput**](../Model/RoleInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\RoleData**](../Model/RoleData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

