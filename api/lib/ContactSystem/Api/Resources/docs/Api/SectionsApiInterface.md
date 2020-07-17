# OpenAPI\Server\Api\SectionsApiInterface

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addSectionLocalMarkerById**](SectionsApiInterface.md#addSectionLocalMarkerById) | **PUT** /sections/{sectionId}/local | 
[**createSection**](SectionsApiInterface.md#createSection) | **POST** /sections | Create Section
[**deleteSectionById**](SectionsApiInterface.md#deleteSectionById) | **DELETE** /sections/{sectionId} | Delete Section
[**getSectionById**](SectionsApiInterface.md#getSectionById) | **GET** /sections/{sectionId} | Get Section
[**getSectionMembersById**](SectionsApiInterface.md#getSectionMembersById) | **GET** /sections/{sectionId}/members | Your GET endpoint
[**getSections**](SectionsApiInterface.md#getSections) | **GET** /sections | Get Sections
[**removeSectionLocalMarkerById**](SectionsApiInterface.md#removeSectionLocalMarkerById) | **DELETE** /sections/{sectionId}/local | 
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

## **addSectionLocalMarkerById**
> OpenAPI\Server\Model\ApiResponse addSectionLocalMarkerById($sectionId)



addSectionLocalMarkerById

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
    public function addSectionLocalMarkerById(int $sectionId)
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

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

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

[contact_auth](../../README.md#contact_auth)

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

[contact_auth](../../README.md#contact_auth)

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

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getSectionMembersById**
> OpenAPI\Server\Model\MemberData getSectionMembersById($sectionId)

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
     * Implementation of SectionsApiInterface#getSectionMembersById
     */
    public function getSectionMembersById(int $sectionId)
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

[**OpenAPI\Server\Model\MemberData**](../Model/MemberData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getSections**
> OpenAPI\Server\Model\SectionData getSections($sort, $pageSize, $page)

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
    public function getSections(string $sort = null, int $pageSize = null, int $page = null)
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

[**OpenAPI\Server\Model\SectionData**](../Model/SectionData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **removeSectionLocalMarkerById**
> OpenAPI\Server\Model\ApiResponse removeSectionLocalMarkerById($sectionId)



removeSectionLocalMarkerById

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
    public function removeSectionLocalMarkerById(int $sectionId)
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

[contact_auth](../../README.md#contact_auth)

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

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

