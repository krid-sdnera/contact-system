# OpenAPI\Server\Api\SectionsApiInterface

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createSection**](SectionsApiInterface.md#createSection) | **POST** /sections | Create Section
[**deleteSectionById**](SectionsApiInterface.md#deleteSectionById) | **DELETE** /sections/{sectionId} | Delete Section
[**getSectionById**](SectionsApiInterface.md#getSectionById) | **GET** /sections/{sectionId} | Get Section
[**getSectionRolesById**](SectionsApiInterface.md#getSectionRolesById) | **GET** /sections/{sectionId}/roles | Your GET endpoint
[**getSections**](SectionsApiInterface.md#getSections) | **GET** /sections | Get Sections
[**updateSectionById**](SectionsApiInterface.md#updateSectionById) | **PUT** /sections/{sectionId} | Update Section


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

## **createSection**
> OpenAPI\Server\Model\SectionData createSection($sectionInput)

Create Section

Create Section

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
    public function createSection(SectionInput $sectionInput = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **sectionInput** | [**OpenAPI\Server\Model\SectionInput**](../Model/SectionInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\SectionData**](../Model/SectionData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **deleteSectionById**
> OpenAPI\Server\Model\ApiResponse deleteSectionById($sectionId)

Delete Section

Delete Section

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
    public function deleteSectionById(int $sectionId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **sectionId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getSectionById**
> OpenAPI\Server\Model\SectionData getSectionById($sectionId)

Get Section

Get Section

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
    public function getSectionById(int $sectionId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **sectionId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\SectionData**](../Model/SectionData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getSectionRolesById**
> OpenAPI\Server\Model\Roles getSectionRolesById($sectionId)

Your GET endpoint

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
     * Implementation of SectionsApiInterface#getSectionRolesById
     */
    public function getSectionRolesById(int $sectionId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **sectionId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\Roles**](../Model/Roles.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getSections**
> OpenAPI\Server\Model\Sections getSections($query, $sort, $pageSize, $page)

Get Sections

Get Sections

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
    public function getSections(string $query = null, string $sort = null, int $pageSize = null, int $page = null)
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

[**OpenAPI\Server\Model\Sections**](../Model/Sections.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **updateSectionById**
> OpenAPI\Server\Model\SectionData updateSectionById($sectionId, $sectionInput)

Update Section

Update Section

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
    public function updateSectionById(int $sectionId, SectionInput $sectionInput = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **sectionId** | **int**|  |
 **sectionInput** | [**OpenAPI\Server\Model\SectionInput**](../Model/SectionInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\SectionData**](../Model/SectionData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

