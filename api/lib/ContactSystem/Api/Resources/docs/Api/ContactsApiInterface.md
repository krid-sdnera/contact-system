# OpenAPI\Server\Api\ContactsApiInterface

All URIs are relative to *https://membership.essendonseascouts.org.au/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**createContact**](ContactsApiInterface.md#createContact) | **POST** /contacts | Create Contact
[**deleteContactById**](ContactsApiInterface.md#deleteContactById) | **DELETE** /contacts/{contactId} | Delete Contact By ID
[**getContactById**](ContactsApiInterface.md#getContactById) | **GET** /contacts/{contactId} | Get Contact By ID
[**getContacts**](ContactsApiInterface.md#getContacts) | **GET** /contacts | List Contacts
[**getListRulesByContactId**](ContactsApiInterface.md#getListRulesByContactId) | **GET** /contacts/{contactId}/list-rules | Get List Rules By Contact ID
[**patchContactById**](ContactsApiInterface.md#patchContactById) | **PATCH** /contacts/{contactId} | Patch Contact By ID
[**updateContactById**](ContactsApiInterface.md#updateContactById) | **PUT** /contacts/{contactId} | Update Contact By ID


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
> OpenAPI\Server\Model\ContactResponse createContact($contactInput)

Create Contact

create Contact

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

[**OpenAPI\Server\Model\ContactResponse**](../Model/ContactResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **deleteContactById**
> OpenAPI\Server\Model\ApiResponse deleteContactById($contactId)

Delete Contact By ID

Delete Contact By ID

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
> OpenAPI\Server\Model\ContactResponse getContactById($contactId)

Get Contact By ID

Get Contact By ID

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

[**OpenAPI\Server\Model\ContactResponse**](../Model/ContactResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getContacts**
> OpenAPI\Server\Model\Contacts getContacts($query, $sort, $pageSize, $page)

List Contacts

Returns a list of Contacts

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

## **getListRulesByContactId**
> OpenAPI\Server\Model\ListRules getListRulesByContactId($contactId, $query, $sort, $pageSize, $page)

Get List Rules By Contact ID

Get List Rules By Contact ID

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
     * Implementation of ContactsApiInterface#getListRulesByContactId
     */
    public function getListRulesByContactId(int $contactId, string $query = null, string $sort = null, int $pageSize = null, int $page = null)
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
 **query** | **string**|  | [optional]
 **sort** | **string**|  | [optional]
 **pageSize** | **int**|  | [optional]
 **page** | **int**|  | [optional]

### Return type

[**OpenAPI\Server\Model\ListRules**](../Model/ListRules.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **patchContactById**
> OpenAPI\Server\Model\ContactResponse patchContactById($contactId, $contactInput)

Patch Contact By ID

Patch Contact By ID

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

[**OpenAPI\Server\Model\ContactResponse**](../Model/ContactResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **updateContactById**
> OpenAPI\Server\Model\ContactResponse updateContactById($contactId, $contactInput)

Update Contact By ID

Update Contact By ID

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

[**OpenAPI\Server\Model\ContactResponse**](../Model/ContactResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

