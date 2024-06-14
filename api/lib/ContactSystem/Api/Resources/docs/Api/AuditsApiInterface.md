# OpenAPI\Server\Api\AuditsApiInterface

All URIs are relative to *https://membership.essendonseascouts.org.au/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**getAudits**](AuditsApiInterface.md#getAudits) | **GET** /audits | Get Audits


## Service Declaration
```yaml
# src/Acme/MyBundle/Resources/services.yml
services:
    # ...
    acme.my_bundle.api.audits:
        class: Acme\MyBundle\Api\AuditsApi
        tags:
            - { name: "open_api_server.api", api: "audits" }
    # ...
```

## **getAudits**
> OpenAPI\Server\Model\Audits getAudits($query, $sort, $pageSize, $page)

Get Audits

Get Audits

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/AuditsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\AuditsApiInterface;

class AuditsApi implements AuditsApiInterface
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
     * Implementation of AuditsApiInterface#getAudits
     */
    public function getAudits(string $query = null, string $sort = null, int $pageSize = null, int $page = null)
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

[**OpenAPI\Server\Model\Audits**](../Model/Audits.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

