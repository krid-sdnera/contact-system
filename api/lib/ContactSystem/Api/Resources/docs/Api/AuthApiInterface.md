# OpenAPI\Server\Api\AuthApiInterface

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getJWT**](AuthApiInterface.md#getJWT) | **POST** /auth/token | Get JWT
[**refreshJWT**](AuthApiInterface.md#refreshJWT) | **POST** /auth/token/refresh | Refresh JWT


## Service Declaration
```yaml
# src/Acme/MyBundle/Resources/services.yml
services:
    # ...
    acme.my_bundle.api.auth:
        class: Acme\MyBundle\Api\AuthApi
        tags:
            - { name: "open_api_server.api", api: "auth" }
    # ...
```

## **getJWT**
> OpenAPI\Server\Model\JwtErrorResponse getJWT($jwtInput)

Get JWT

Get a JWT

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/AuthApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\AuthApiInterface;

class AuthApi implements AuthApiInterface
{

    // ...

    /**
     * Implementation of AuthApiInterface#getJWT
     */
    public function getJWT(JwtInput $jwtInput = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **jwtInput** | [**OpenAPI\Server\Model\JwtInput**](../Model/JwtInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\JwtErrorResponse**](../Model/JwtErrorResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **refreshJWT**
> OpenAPI\Server\Model\JwtErrorResponse refreshJWT($refreshToken)

Refresh JWT

Refresh a JWT

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/AuthApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\AuthApiInterface;

class AuthApi implements AuthApiInterface
{

    // ...

    /**
     * Implementation of AuthApiInterface#refreshJWT
     */
    public function refreshJWT(string $refreshToken)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **refreshToken** | **string**| The refresh token |

### Return type

[**OpenAPI\Server\Model\JwtErrorResponse**](../Model/JwtErrorResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/x-www-form-urlencoded
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

