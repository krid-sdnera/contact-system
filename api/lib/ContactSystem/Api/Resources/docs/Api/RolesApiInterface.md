# OpenAPI\Server\Api\RolesApiInterface

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createRole**](RolesApiInterface.md#createRole) | **POST** /roles | Create role
[**deleteRoleById**](RolesApiInterface.md#deleteRoleById) | **DELETE** /roles/{roleId} | Delete role
[**getRoleById**](RolesApiInterface.md#getRoleById) | **GET** /roles/{roleId} | Get Role
[**getRoleMembersById**](RolesApiInterface.md#getRoleMembersById) | **GET** /roles/{roleId}/members | Get role members
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

[contact_auth](../../README.md#contact_auth)

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

[contact_auth](../../README.md#contact_auth)

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

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getRoleMembersById**
> OpenAPI\Server\Model\MemberData getRoleMembersById($roleId, $sort, $pageSize, $page)

Get role members

Get role members

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
     * Implementation of RolesApiInterface#getRoleMembersById
     */
    public function getRoleMembersById(int $roleId, string $sort = null, int $pageSize = null, int $page = null)
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
 **sort** | **string**|  | [optional]
 **pageSize** | **int**|  | [optional]
 **page** | **int**|  | [optional]

### Return type

[**OpenAPI\Server\Model\MemberData**](../Model/MemberData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getRoles**
> OpenAPI\Server\Model\RoleData getRoles($sort, $pageSize, $page)

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
    public function getRoles(string $sort = null, int $pageSize = null, int $page = null)
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

[**OpenAPI\Server\Model\RoleData**](../Model/RoleData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

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

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

