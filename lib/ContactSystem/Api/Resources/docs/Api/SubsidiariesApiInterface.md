# OpenAPI\Server\Api\SubsidiariesApiInterface

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**deleteSubsidiariesSubsidiaryId**](SubsidiariesApiInterface.md#deleteSubsidiariesSubsidiaryId) | **DELETE** /subsidiaries/{subsidiaryId} | 
[**deleteSubsidiariesSubsidiaryIdLocal**](SubsidiariesApiInterface.md#deleteSubsidiariesSubsidiaryIdLocal) | **DELETE** /subsidiaries/{subsidiaryId}/local | 
[**getSubsidiaries**](SubsidiariesApiInterface.md#getSubsidiaries) | **GET** /subsidiaries | Your GET endpoint
[**getSubsidiariesSubsidiaryId**](SubsidiariesApiInterface.md#getSubsidiariesSubsidiaryId) | **GET** /subsidiaries/{subsidiaryId} | Your GET endpoint
[**getSubsidiariesSubsidiaryIdMembers**](SubsidiariesApiInterface.md#getSubsidiariesSubsidiaryIdMembers) | **GET** /subsidiaries/{subsidiaryId}/members | Your GET endpoint
[**postSubsidiaries**](SubsidiariesApiInterface.md#postSubsidiaries) | **POST** /subsidiaries | 
[**putSubsidiariesSubsidiaryId**](SubsidiariesApiInterface.md#putSubsidiariesSubsidiaryId) | **PUT** /subsidiaries/{subsidiaryId} | 
[**putSubsidiariesSubsidiaryIdLocal**](SubsidiariesApiInterface.md#putSubsidiariesSubsidiaryIdLocal) | **PUT** /subsidiaries/{subsidiaryId}/local | 


## Service Declaration
```yaml
# src/Acme/MyBundle/Resources/services.yml
services:
    # ...
    acme.my_bundle.api.subsidiaries:
        class: Acme\MyBundle\Api\SubsidiariesApi
        tags:
            - { name: "open_api_server.api", api: "subsidiaries" }
    # ...
```

## **deleteSubsidiariesSubsidiaryId**
> OpenAPI\Server\Model\ApiResponse deleteSubsidiariesSubsidiaryId($subsidiaryId)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/SubsidiariesApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\SubsidiariesApiInterface;

class SubsidiariesApi implements SubsidiariesApiInterface
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
     * Implementation of SubsidiariesApiInterface#deleteSubsidiariesSubsidiaryId
     */
    public function deleteSubsidiariesSubsidiaryId($subsidiaryId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **subsidiaryId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **deleteSubsidiariesSubsidiaryIdLocal**
> OpenAPI\Server\Model\ApiResponse deleteSubsidiariesSubsidiaryIdLocal($subsidiaryId)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/SubsidiariesApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\SubsidiariesApiInterface;

class SubsidiariesApi implements SubsidiariesApiInterface
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
     * Implementation of SubsidiariesApiInterface#deleteSubsidiariesSubsidiaryIdLocal
     */
    public function deleteSubsidiariesSubsidiaryIdLocal($subsidiaryId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **subsidiaryId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getSubsidiaries**
> OpenAPI\Server\Model\Subsidiary getSubsidiaries()

Your GET endpoint

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/SubsidiariesApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\SubsidiariesApiInterface;

class SubsidiariesApi implements SubsidiariesApiInterface
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
     * Implementation of SubsidiariesApiInterface#getSubsidiaries
     */
    public function getSubsidiaries()
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**OpenAPI\Server\Model\Subsidiary**](../Model/Subsidiary.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getSubsidiariesSubsidiaryId**
> OpenAPI\Server\Model\Subsidiary getSubsidiariesSubsidiaryId($subsidiaryId)

Your GET endpoint

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/SubsidiariesApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\SubsidiariesApiInterface;

class SubsidiariesApi implements SubsidiariesApiInterface
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
     * Implementation of SubsidiariesApiInterface#getSubsidiariesSubsidiaryId
     */
    public function getSubsidiariesSubsidiaryId($subsidiaryId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **subsidiaryId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\Subsidiary**](../Model/Subsidiary.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getSubsidiariesSubsidiaryIdMembers**
> string getSubsidiariesSubsidiaryIdMembers($subsidiaryId)

Your GET endpoint

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/SubsidiariesApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\SubsidiariesApiInterface;

class SubsidiariesApi implements SubsidiariesApiInterface
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
     * Implementation of SubsidiariesApiInterface#getSubsidiariesSubsidiaryIdMembers
     */
    public function getSubsidiariesSubsidiaryIdMembers($subsidiaryId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **subsidiaryId** | **string**|  |

### Return type

**string**

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **postSubsidiaries**
> postSubsidiaries()



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/SubsidiariesApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\SubsidiariesApiInterface;

class SubsidiariesApi implements SubsidiariesApiInterface
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
     * Implementation of SubsidiariesApiInterface#postSubsidiaries
     */
    public function postSubsidiaries()
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters
This endpoint does not need any parameter.

### Return type

void (empty response body)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: Not defined

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **putSubsidiariesSubsidiaryId**
> OpenAPI\Server\Model\Subsidiary putSubsidiariesSubsidiaryId($subsidiaryId, $subsidiary)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/SubsidiariesApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\SubsidiariesApiInterface;

class SubsidiariesApi implements SubsidiariesApiInterface
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
     * Implementation of SubsidiariesApiInterface#putSubsidiariesSubsidiaryId
     */
    public function putSubsidiariesSubsidiaryId($subsidiaryId, Subsidiary $subsidiary = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **subsidiaryId** | **string**|  |
 **subsidiary** | [**OpenAPI\Server\Model\Subsidiary**](../Model/Subsidiary.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\Subsidiary**](../Model/Subsidiary.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **putSubsidiariesSubsidiaryIdLocal**
> OpenAPI\Server\Model\ApiResponse putSubsidiariesSubsidiaryIdLocal($subsidiaryId)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/SubsidiariesApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\SubsidiariesApiInterface;

class SubsidiariesApi implements SubsidiariesApiInterface
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
     * Implementation of SubsidiariesApiInterface#putSubsidiariesSubsidiaryIdLocal
     */
    public function putSubsidiariesSubsidiaryIdLocal($subsidiaryId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **subsidiaryId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

