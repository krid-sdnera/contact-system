# OpenAPI\Server\Api\SectionsApiInterface

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addSectionLocalMarkerById**](SectionsApiInterface.md#addSectionLocalMarkerById) | **PUT** /sections/{sectionId}/local | 
[**createSection**](SectionsApiInterface.md#createSection) | **POST** /sections | 
[**deleteSectionById**](SectionsApiInterface.md#deleteSectionById) | **DELETE** /sections/{sectionId} | 
[**getSectionById**](SectionsApiInterface.md#getSectionById) | **GET** /sections/{sectionId} | Your GET endpoint
[**getSectionMembersById**](SectionsApiInterface.md#getSectionMembersById) | **GET** /sections/{sectionId}/members | Your GET endpoint
[**getSections**](SectionsApiInterface.md#getSections) | **GET** /sections | Your GET endpoint
[**removeSectionLocalMarkerById**](SectionsApiInterface.md#removeSectionLocalMarkerById) | **DELETE** /sections/{sectionId}/local | 
[**updateSectionById**](SectionsApiInterface.md#updateSectionById) | **PUT** /sections/{sectionId} | 


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

## **addSectionLocalMarkerById**
> OpenAPI\Server\Model\ApiResponse addSectionLocalMarkerById($sectionId)



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
     * Implementation of SectionsApiInterface#addSectionLocalMarkerById
     */
    public function addSectionLocalMarkerById($sectionId)
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

## **createSection**
> OpenAPI\Server\Model\Section createSection($section)



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
     * Implementation of SectionsApiInterface#createSection
     */
    public function createSection(Section $section = null)
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

## **deleteSectionById**
> OpenAPI\Server\Model\ApiResponse deleteSectionById($sectionId)



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
     * Implementation of SectionsApiInterface#deleteSectionById
     */
    public function deleteSectionById($sectionId)
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

## **getSectionById**
> OpenAPI\Server\Model\Section getSectionById($sectionId)

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
     * Implementation of SectionsApiInterface#getSectionById
     */
    public function getSectionById($sectionId)
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

## **getSectionMembersById**
> string getSectionMembersById($sectionId)

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
     * Implementation of SectionsApiInterface#getSectionMembersById
     */
    public function getSectionMembersById($sectionId)
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

## **removeSectionLocalMarkerById**
> OpenAPI\Server\Model\ApiResponse removeSectionLocalMarkerById($sectionId)



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
     * Implementation of SectionsApiInterface#removeSectionLocalMarkerById
     */
    public function removeSectionLocalMarkerById($sectionId)
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

## **updateSectionById**
> OpenAPI\Server\Model\Section updateSectionById($sectionId, $section)



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
     * Implementation of SectionsApiInterface#updateSectionById
     */
    public function updateSectionById($sectionId, Section $section = null)
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

