# OpenAPI\Server\Api\ContactsApiInterface

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createContact**](ContactsApiInterface.md#createContact) | **POST** /contacts | 
[**deleteContactById**](ContactsApiInterface.md#deleteContactById) | **DELETE** /contacts/{contactId} | 
[**getContactById**](ContactsApiInterface.md#getContactById) | **GET** /contacts/{contactId} | Your GET endpoint
[**getContacts**](ContactsApiInterface.md#getContacts) | **GET** /contacts | Your GET endpoint
[**patchContactById**](ContactsApiInterface.md#patchContactById) | **PATCH** /contacts/{contactId} | 
[**updateContactById**](ContactsApiInterface.md#updateContactById) | **PUT** /contacts/{contactId} | 


## Service Declaration
```yaml
# src/Acme/MyBundle/Resources/services.yml
services:
    # ...
    acme.my_bundle.api.contacts:
        class: Acme\MyBundle\Api\ContactsApi
        tags:
            - { name: "open_api_server.api", api: "contacts" }
    # ...
```

## **createContact**
> OpenAPI\Server\Model\ContactData createContact($contactInput)



createContact

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ContactsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ContactsApiInterface;

class ContactsApi implements ContactsApiInterface
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
     * Implementation of ContactsApiInterface#createContact
     */
    public function createContact(ContactInput $contactInput = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **contactInput** | [**OpenAPI\Server\Model\ContactInput**](../Model/ContactInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\ContactData**](../Model/ContactData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **deleteContactById**
> OpenAPI\Server\Model\ApiResponse deleteContactById($contactId)



deleteContactById

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ContactsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ContactsApiInterface;

class ContactsApi implements ContactsApiInterface
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
     * Implementation of ContactsApiInterface#deleteContactById
     */
    public function deleteContactById(int $contactId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **contactId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getContactById**
> OpenAPI\Server\Model\ContactData getContactById($contactId)

Your GET endpoint

getContactById

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ContactsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ContactsApiInterface;

class ContactsApi implements ContactsApiInterface
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
     * Implementation of ContactsApiInterface#getContactById
     */
    public function getContactById(int $contactId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **contactId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\ContactData**](../Model/ContactData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getContacts**
> OpenAPI\Server\Model\Contacts getContacts($query, $sort, $pageSize, $page)

Your GET endpoint

Your GET endpoint

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ContactsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ContactsApiInterface;

class ContactsApi implements ContactsApiInterface
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
     * Implementation of ContactsApiInterface#getContacts
     */
    public function getContacts(string $query = null, string $sort = null, int $pageSize = null, int $page = null)
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

[**OpenAPI\Server\Model\Contacts**](../Model/Contacts.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **patchContactById**
> OpenAPI\Server\Model\ContactData patchContactById($contactId, $contactInput)



patchContactById

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ContactsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ContactsApiInterface;

class ContactsApi implements ContactsApiInterface
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
     * Implementation of ContactsApiInterface#patchContactById
     */
    public function patchContactById(int $contactId, ContactInput $contactInput = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **contactId** | **int**|  |
 **contactInput** | [**OpenAPI\Server\Model\ContactInput**](../Model/ContactInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\ContactData**](../Model/ContactData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **updateContactById**
> OpenAPI\Server\Model\ContactData updateContactById($contactId, $contactInput)



updateContactById

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/ContactsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\ContactsApiInterface;

class ContactsApi implements ContactsApiInterface
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
     * Implementation of ContactsApiInterface#updateContactById
     */
    public function updateContactById(int $contactId, ContactInput $contactInput = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **contactId** | **int**|  |
 **contactInput** | [**OpenAPI\Server\Model\ContactInput**](../Model/ContactInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\ContactData**](../Model/ContactData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

