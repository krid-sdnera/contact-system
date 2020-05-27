# OpenAPI\Server\Api\MembersApiInterface

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addMemberLocalMarkerById**](MembersApiInterface.md#addMemberLocalMarkerById) | **PUT** /members/{memberId}/local | Add local marker
[**createMember**](MembersApiInterface.md#createMember) | **POST** /members | Create a member
[**deleteMemberById**](MembersApiInterface.md#deleteMemberById) | **DELETE** /members/{memberId} | Delete member
[**getMemberById**](MembersApiInterface.md#getMemberById) | **GET** /members/{memberId} | Get member
[**getMemberLocalMarkerSuggestionsById**](MembersApiInterface.md#getMemberLocalMarkerSuggestionsById) | **GET** /members/{memberId}/local/suggestions | Get member suggestions
[**getMembers**](MembersApiInterface.md#getMembers) | **GET** /members | List all members
[**mergeMember**](MembersApiInterface.md#mergeMember) | **POST** /members/{memberId}/merge_into/{mergeMemberId} | Merge member
[**removeMemberLocalMarkerById**](MembersApiInterface.md#removeMemberLocalMarkerById) | **DELETE** /members/{memberId}/local | Remove local marker
[**removeMemberSectionById**](MembersApiInterface.md#removeMemberSectionById) | **DELETE** /members/{memberId}/section | 
[**setMemberGroupById**](MembersApiInterface.md#setMemberGroupById) | **PUT** /members/{memberId}/group | 
[**setMemberSectionById**](MembersApiInterface.md#setMemberSectionById) | **PUT** /members/{memberId}/section | 
[**updateMemberById**](MembersApiInterface.md#updateMemberById) | **PUT** /members/{memberId} | Update member


## Service Declaration
```yaml
# src/Acme/MyBundle/Resources/services.yml
services:
    # ...
    acme.my_bundle.api.members:
        class: Acme\MyBundle\Api\MembersApi
        tags:
            - { name: "open_api_server.api", api: "members" }
    # ...
```

## **addMemberLocalMarkerById**
> OpenAPI\Server\Model\ApiResponse addMemberLocalMarkerById($memberId)

Add local marker

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/MembersApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\MembersApiInterface;

class MembersApi implements MembersApiInterface
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
     * Implementation of MembersApiInterface#addMemberLocalMarkerById
     */
    public function addMemberLocalMarkerById($memberId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **createMember**
> OpenAPI\Server\Model\MemberData createMember($memberInput)

Create a member

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/MembersApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\MembersApiInterface;

class MembersApi implements MembersApiInterface
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
     * Implementation of MembersApiInterface#createMember
     */
    public function createMember(MemberInput $memberInput)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberInput** | [**OpenAPI\Server\Model\MemberInput**](../Model/MemberInput.md)|  |

### Return type

[**OpenAPI\Server\Model\MemberData**](../Model/MemberData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **deleteMemberById**
> OpenAPI\Server\Model\ApiResponse deleteMemberById($memberId)

Delete member

Delete a member

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/MembersApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\MembersApiInterface;

class MembersApi implements MembersApiInterface
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
     * Implementation of MembersApiInterface#deleteMemberById
     */
    public function deleteMemberById($memberId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getMemberById**
> OpenAPI\Server\Model\MemberData getMemberById($memberId)

Get member

Get details for a member

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/MembersApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\MembersApiInterface;

class MembersApi implements MembersApiInterface
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
     * Implementation of MembersApiInterface#getMemberById
     */
    public function getMemberById($memberId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\MemberData**](../Model/MemberData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getMemberLocalMarkerSuggestionsById**
> OpenAPI\Server\Model\MemberSuggetion getMemberLocalMarkerSuggestionsById($memberId, $sort, $pageSize, $page)

Get member suggestions

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/MembersApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\MembersApiInterface;

class MembersApi implements MembersApiInterface
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
     * Implementation of MembersApiInterface#getMemberLocalMarkerSuggestionsById
     */
    public function getMemberLocalMarkerSuggestionsById($memberId, $sort = null, $pageSize = null, $page = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberId** | **string**|  |
 **sort** | **string**|  | [optional]
 **pageSize** | **int**|  | [optional]
 **page** | **int**|  | [optional]

### Return type

[**OpenAPI\Server\Model\MemberSuggetion**](../Model/MemberSuggetion.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getMembers**
> OpenAPI\Server\Model\Members getMembers($sort, $pageSize, $page)

List all members

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/MembersApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\MembersApiInterface;

class MembersApi implements MembersApiInterface
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
     * Implementation of MembersApiInterface#getMembers
     */
    public function getMembers($sort = null, $pageSize = null, $page = null)
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

[**OpenAPI\Server\Model\Members**](../Model/Members.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **mergeMember**
> OpenAPI\Server\Model\ApiResponse mergeMember($memberId, $mergeMemberId)

Merge member

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/MembersApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\MembersApiInterface;

class MembersApi implements MembersApiInterface
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
     * Implementation of MembersApiInterface#mergeMember
     */
    public function mergeMember($memberId, $mergeMemberId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberId** | **string**|  |
 **mergeMemberId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **removeMemberLocalMarkerById**
> OpenAPI\Server\Model\ApiResponse removeMemberLocalMarkerById($memberId)

Remove local marker

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/MembersApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\MembersApiInterface;

class MembersApi implements MembersApiInterface
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
     * Implementation of MembersApiInterface#removeMemberLocalMarkerById
     */
    public function removeMemberLocalMarkerById($memberId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **removeMemberSectionById**
> OpenAPI\Server\Model\ApiResponse removeMemberSectionById($memberId)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/MembersApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\MembersApiInterface;

class MembersApi implements MembersApiInterface
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
     * Implementation of MembersApiInterface#removeMemberSectionById
     */
    public function removeMemberSectionById($memberId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **setMemberGroupById**
> OpenAPI\Server\Model\GroupData setMemberGroupById($memberId, $groupInput)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/MembersApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\MembersApiInterface;

class MembersApi implements MembersApiInterface
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
     * Implementation of MembersApiInterface#setMemberGroupById
     */
    public function setMemberGroupById($memberId, GroupInput $groupInput = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberId** | **string**|  |
 **groupInput** | [**OpenAPI\Server\Model\GroupInput**](../Model/GroupInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\GroupData**](../Model/GroupData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **setMemberSectionById**
> OpenAPI\Server\Model\ApiResponse setMemberSectionById($memberId, $sectionData)



### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/MembersApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\MembersApiInterface;

class MembersApi implements MembersApiInterface
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
     * Implementation of MembersApiInterface#setMemberSectionById
     */
    public function setMemberSectionById($memberId, array $sectionData = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberId** | **string**|  |
 **sectionData** | [**OpenAPI\Server\Model\SectionData**](../Model/SectionData.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **updateMemberById**
> OpenAPI\Server\Model\MemberData updateMemberById($memberId, $memberInput)

Update member

Update a member's detail

### Example Implementation
```php
<?php
// src/Acme/MyBundle/Api/MembersApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\MembersApiInterface;

class MembersApi implements MembersApiInterface
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
     * Implementation of MembersApiInterface#updateMemberById
     */
    public function updateMemberById($memberId, MemberInput $memberInput = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberId** | **string**|  |
 **memberInput** | [**OpenAPI\Server\Model\MemberInput**](../Model/MemberInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\MemberData**](../Model/MemberData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

