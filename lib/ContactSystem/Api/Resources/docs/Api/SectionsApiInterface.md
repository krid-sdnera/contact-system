# OpenAPI\Server\Api\SectionsApiInterface

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**deleteSectionsSectionId**](SectionsApiInterface.md#deleteSectionsSectionId) | **DELETE** /sections/{sectionId} | 
[**deleteSectionsSectionIdLocal**](SectionsApiInterface.md#deleteSectionsSectionIdLocal) | **DELETE** /sections/{sectionId}/local | 
[**getSections**](SectionsApiInterface.md#getSections) | **GET** /sections | Your GET endpoint
[**getSectionsSectionId**](SectionsApiInterface.md#getSectionsSectionId) | **GET** /sections/{sectionId} | Your GET endpoint
[**getSectionsSectionIdMembers**](SectionsApiInterface.md#getSectionsSectionIdMembers) | **GET** /sections/{sectionId}/members | Your GET endpoint
[**postSections**](SectionsApiInterface.md#postSections) | **POST** /sections | 
[**putSectionsSectionId**](SectionsApiInterface.md#putSectionsSectionId) | **PUT** /sections/{sectionId} | 
[**putSectionsSectionIdLocal**](SectionsApiInterface.md#putSectionsSectionIdLocal) | **PUT** /sections/{sectionId}/local | 


## Service Declaration
```yaml
# src/Acme/MyBundle/Resources/services.yml
services:
    # ...
    acme.my_bundle.api.sections:
        class: Acme\MyBundle\Api\SectionsApi
        tags:
            - { name: "open_api_server.api", api: "sections" }
    # ...
```

## **deleteSectionsSectionId**
> OpenAPI\Server\Model\ApiResponse deleteSectionsSectionId($sectionId)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/SectionsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\SectionsApiInterface;

class SectionsApi implements SectionsApiInterface
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
     * Implementation of SectionsApiInterface#deleteSectionsSectionId
     */
    public function deleteSectionsSectionId($sectionId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **sectionId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **deleteSectionsSectionIdLocal**
> OpenAPI\Server\Model\ApiResponse deleteSectionsSectionIdLocal($sectionId)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/SectionsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\SectionsApiInterface;

class SectionsApi implements SectionsApiInterface
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
     * Implementation of SectionsApiInterface#deleteSectionsSectionIdLocal
     */
    public function deleteSectionsSectionIdLocal($sectionId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **sectionId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getSections**
> OpenAPI\Server\Model\Section getSections()

Your GET endpoint

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/SectionsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\SectionsApiInterface;

class SectionsApi implements SectionsApiInterface
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
     * Implementation of SectionsApiInterface#getSections
     */
    public function getSections()
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters
This endpoint does not need any parameter.

### Return type

[**OpenAPI\Server\Model\Section**](../Model/Section.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getSectionsSectionId**
> OpenAPI\Server\Model\Section getSectionsSectionId($sectionId)

Your GET endpoint

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/SectionsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\SectionsApiInterface;

class SectionsApi implements SectionsApiInterface
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
     * Implementation of SectionsApiInterface#getSectionsSectionId
     */
    public function getSectionsSectionId($sectionId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **sectionId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\Section**](../Model/Section.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getSectionsSectionIdMembers**
> string getSectionsSectionIdMembers($sectionId)

Your GET endpoint

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/SectionsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\SectionsApiInterface;

class SectionsApi implements SectionsApiInterface
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
     * Implementation of SectionsApiInterface#getSectionsSectionIdMembers
     */
    public function getSectionsSectionIdMembers($sectionId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **sectionId** | **string**|  |

### Return type

**string**

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **postSections**
> OpenAPI\Server\Model\Section postSections($section)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/SectionsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\SectionsApiInterface;

class SectionsApi implements SectionsApiInterface
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
     * Implementation of SectionsApiInterface#postSections
     */
    public function postSections(Section $section = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **section** | [**OpenAPI\Server\Model\Section**](../Model/Section.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\Section**](../Model/Section.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **putSectionsSectionId**
> OpenAPI\Server\Model\Section putSectionsSectionId($sectionId, $section)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/SectionsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\SectionsApiInterface;

class SectionsApi implements SectionsApiInterface
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
     * Implementation of SectionsApiInterface#putSectionsSectionId
     */
    public function putSectionsSectionId($sectionId, Section $section = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **sectionId** | **string**|  |
 **section** | [**OpenAPI\Server\Model\Section**](../Model/Section.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\Section**](../Model/Section.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **putSectionsSectionIdLocal**
> OpenAPI\Server\Model\ApiResponse putSectionsSectionIdLocal($sectionId)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/SectionsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\SectionsApiInterface;

class SectionsApi implements SectionsApiInterface
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
     * Implementation of SectionsApiInterface#putSectionsSectionIdLocal
     */
    public function putSectionsSectionIdLocal($sectionId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **sectionId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

