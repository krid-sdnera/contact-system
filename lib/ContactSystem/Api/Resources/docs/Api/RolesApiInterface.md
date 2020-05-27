# OpenAPI\Server\Api\RolesApiInterface

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createCustomRole**](RolesApiInterface.md#createCustomRole) | **POST** /roles/custom | 
[**deleteCustomRoleById**](RolesApiInterface.md#deleteCustomRoleById) | **DELETE** /roles/custom/{customRoleId} | 
[**getCustomRoleById**](RolesApiInterface.md#getCustomRoleById) | **GET** /roles/custom/{customRoleId} | Your GET endpoint
[**getCustomRoleMembersById**](RolesApiInterface.md#getCustomRoleMembersById) | **GET** /roles/custom/{customRoleId}/members | Your GET endpoint
[**getCustomRoles**](RolesApiInterface.md#getCustomRoles) | **GET** /roles/custom | Your GET endpoint
[**updateCustomRoleById**](RolesApiInterface.md#updateCustomRoleById) | **PUT** /roles/custom/{customRoleId} | 


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

## **createCustomRole**
> OpenAPI\Server\Model\Role createCustomRole($role)



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
     * Implementation of RolesApiInterface#createCustomRole
     */
    public function createCustomRole(Role $role = null)
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

## **deleteCustomRoleById**
> OpenAPI\Server\Model\ApiResponse deleteCustomRoleById($customRoleId)



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
     * Implementation of RolesApiInterface#deleteCustomRoleById
     */
    public function deleteCustomRoleById($customRoleId)
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

## **getCustomRoleById**
> OpenAPI\Server\Model\Role getCustomRoleById($customRoleId)

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
     * Implementation of RolesApiInterface#getCustomRoleById
     */
    public function getCustomRoleById($customRoleId)
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

## **getCustomRoleMembersById**
> string getCustomRoleMembersById($customRoleId)

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
     * Implementation of RolesApiInterface#getCustomRoleMembersById
     */
    public function getCustomRoleMembersById($customRoleId)
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

## **getCustomRoles**
> OpenAPI\Server\Model\Role getCustomRoles()

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
     * Implementation of RolesApiInterface#getCustomRoles
     */
    public function getCustomRoles()
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

## **updateCustomRoleById**
> OpenAPI\Server\Model\Role updateCustomRoleById($customRoleId, $role)



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
     * Implementation of RolesApiInterface#updateCustomRoleById
     */
    public function updateCustomRoleById($customRoleId, Role $role = null)
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

