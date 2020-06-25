# OpenAPI\Server\Api\SubsidiariesApiInterface

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addSubsidiaryLocalMarkerById**](SubsidiariesApiInterface.md#addSubsidiaryLocalMarkerById) | **PUT** /subsidiaries/{subsidiaryId}/local | Add local marker
[**createSubsidiary**](SubsidiariesApiInterface.md#createSubsidiary) | **POST** /subsidiaries | Create subsidiary
[**deleteSubsidiaryById**](SubsidiariesApiInterface.md#deleteSubsidiaryById) | **DELETE** /subsidiaries/{subsidiaryId} | Delete Subsidiary
[**getSubsidiary**](SubsidiariesApiInterface.md#getSubsidiary) | **GET** /subsidiaries | Get Subsidiary
[**getSubsidiaryById**](SubsidiariesApiInterface.md#getSubsidiaryById) | **GET** /subsidiaries/{subsidiaryId} | Your GET endpoint
[**getSubsidiaryMembersById**](SubsidiariesApiInterface.md#getSubsidiaryMembersById) | **GET** /subsidiaries/{subsidiaryId}/members | Your GET endpoint
[**removeSubsidiaryLocalMarkerById**](SubsidiariesApiInterface.md#removeSubsidiaryLocalMarkerById) | **DELETE** /subsidiaries/{subsidiaryId}/local | Remove local marker
[**updateSubsidiaryById**](SubsidiariesApiInterface.md#updateSubsidiaryById) | **PUT** /subsidiaries/{subsidiaryId} | Update subsidiary


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

## **addSubsidiaryLocalMarkerById**
> OpenAPI\Server\Model\ApiResponse addSubsidiaryLocalMarkerById($subsidiaryId)

Add local marker

Add local marker

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
     * Implementation of SubsidiariesApiInterface#addSubsidiaryLocalMarkerById
     */
    public function addSubsidiaryLocalMarkerById(string $subsidiaryId)
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

## **createSubsidiary**
> createSubsidiary()

Create subsidiary

Create subsidiary

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
     * Implementation of SubsidiariesApiInterface#createSubsidiary
     */
    public function createSubsidiary()
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

## **deleteSubsidiaryById**
> OpenAPI\Server\Model\ApiResponse deleteSubsidiaryById($subsidiaryId)

Delete Subsidiary

Delete Subsidiary

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
     * Implementation of SubsidiariesApiInterface#deleteSubsidiaryById
     */
    public function deleteSubsidiaryById(string $subsidiaryId)
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

## **getSubsidiary**
> OpenAPI\Server\Model\SubsidiaryData getSubsidiary()

Get Subsidiary

Get Subsidiary

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
     * Implementation of SubsidiariesApiInterface#getSubsidiary
     */
    public function getSubsidiary()
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**OpenAPI\Server\Model\SubsidiaryData**](../Model/SubsidiaryData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getSubsidiaryById**
> OpenAPI\Server\Model\SubsidiaryData getSubsidiaryById($subsidiaryId)

Your GET endpoint

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
     * Implementation of SubsidiariesApiInterface#getSubsidiaryById
     */
    public function getSubsidiaryById(string $subsidiaryId)
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

[**OpenAPI\Server\Model\SubsidiaryData**](../Model/SubsidiaryData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getSubsidiaryMembersById**
> OpenAPI\Server\Model\MemberData getSubsidiaryMembersById($subsidiaryId)

Your GET endpoint

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
     * Implementation of SubsidiariesApiInterface#getSubsidiaryMembersById
     */
    public function getSubsidiaryMembersById(string $subsidiaryId)
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

[**OpenAPI\Server\Model\MemberData**](../Model/MemberData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **removeSubsidiaryLocalMarkerById**
> OpenAPI\Server\Model\ApiResponse removeSubsidiaryLocalMarkerById($subsidiaryId)

Remove local marker

Remove local marker

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
     * Implementation of SubsidiariesApiInterface#removeSubsidiaryLocalMarkerById
     */
    public function removeSubsidiaryLocalMarkerById(string $subsidiaryId)
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

## **updateSubsidiaryById**
> OpenAPI\Server\Model\SubsidiaryData updateSubsidiaryById($subsidiaryId, $subsidiaryInput)

Update subsidiary

Update subsidiary

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
     * Implementation of SubsidiariesApiInterface#updateSubsidiaryById
     */
    public function updateSubsidiaryById(string $subsidiaryId, SubsidiaryInput $subsidiaryInput = null)
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
 **subsidiaryInput** | [**OpenAPI\Server\Model\SubsidiaryInput**](../Model/SubsidiaryInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\SubsidiaryData**](../Model/SubsidiaryData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

