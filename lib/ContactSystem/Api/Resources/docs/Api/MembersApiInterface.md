# OpenAPI\Server\Api\MembersApiInterface

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addMemberLocalMarkerById**](MembersApiInterface.md#addMemberLocalMarkerById) | **PUT** /members/{memberId}/local | Add local marker
[**addMemberRoleById**](MembersApiInterface.md#addMemberRoleById) | **PUT** /members/{memberId}/roles/{roleId} | Add Member Role
[**createMember**](MembersApiInterface.md#createMember) | **POST** /members | Create a member
[**deleteMemberById**](MembersApiInterface.md#deleteMemberById) | **DELETE** /members/{memberId} | Delete member
[**getMemberById**](MembersApiInterface.md#getMemberById) | **GET** /members/{memberId} | Get member
[**getMemberLocalMarkerSuggestionsById**](MembersApiInterface.md#getMemberLocalMarkerSuggestionsById) | **GET** /members/{memberId}/local/suggestions | Get member suggestions
[**getMembers**](MembersApiInterface.md#getMembers) | **GET** /members | List all members
[**mergeMember**](MembersApiInterface.md#mergeMember) | **POST** /members/{memberId}/merge_into/{mergeMemberId} | Merge member
[**removeMemberLocalMarkerById**](MembersApiInterface.md#removeMemberLocalMarkerById) | **DELETE** /members/{memberId}/local | Remove local marker
[**removeMemberRoleById**](MembersApiInterface.md#removeMemberRoleById) | **DELETE** /members/{memberId}/roles/{roleId} | Remove Member Role
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
    public function addMemberLocalMarkerById(string $memberId)
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

## **addMemberRoleById**
> OpenAPI\Server\Model\RoleData addMemberRoleById($memberId, $roleId, $memberRoleInput)

Add Member Role

addMemberRoleById

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
     * Implementation of MembersApiInterface#addMemberRoleById
     */
    public function addMemberRoleById(string $memberId, string $roleId, MemberRoleInput $memberRoleInput = null)
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
 **roleId** | **string**|  |
 **memberRoleInput** | [**OpenAPI\Server\Model\MemberRoleInput**](../Model/MemberRoleInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\RoleData**](../Model/RoleData.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **createMember**
> OpenAPI\Server\Model\MemberData createMember($memberInput)

Create a member

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
    public function deleteMemberById(string $memberId)
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
    public function getMemberById(string $memberId)
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
> OpenAPI\Server\Model\MemberSuggetion getMemberLocalMarkerSuggestionsById($memberId)

Get member suggestions

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
    public function getMemberLocalMarkerSuggestionsById(string $memberId)
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
    public function getMembers(string $sort = null, int $pageSize = null, int $page = null)
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
    public function mergeMember(string $memberId, string $mergeMemberId)
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
    public function removeMemberLocalMarkerById(string $memberId)
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

## **removeMemberRoleById**
> OpenAPI\Server\Model\ApiResponse removeMemberRoleById($memberId, $roleId)

Remove Member Role

removeMemberRoleById

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
     * Implementation of MembersApiInterface#removeMemberRoleById
     */
    public function removeMemberRoleById(string $memberId, string $roleId)
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
 **roleId** | **string**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **updateMemberById**
> OpenAPI\Server\Model\MemberData updateMemberById($memberId, $memberInput)

Update member

Update member

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
    public function updateMemberById(string $memberId, MemberInput $memberInput = null)
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

