# OpenAPI\Server\Api\MembersApiInterface

All URIs are relative to *https://membership.essendonseascouts.org.au/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addMemberRoleById**](MembersApiInterface.md#addMemberRoleById) | **PUT** /members/{memberId}/roles/{roleId} | Add Member Role
[**createMember**](MembersApiInterface.md#createMember) | **POST** /members | Create a member
[**deleteMemberById**](MembersApiInterface.md#deleteMemberById) | **DELETE** /members/{memberId} | Delete member
[**getListRulesByMemberId**](MembersApiInterface.md#getListRulesByMemberId) | **GET** /members/{memberId}/list-rules | Get List Rules by Member ID
[**getMemberById**](MembersApiInterface.md#getMemberById) | **GET** /members/{memberId} | Get Member
[**getMemberContactsById**](MembersApiInterface.md#getMemberContactsById) | **GET** /members/{memberId}/contacts | List member&#39;s contacts
[**getMemberRolesById**](MembersApiInterface.md#getMemberRolesById) | **GET** /members/{memberId}/roles | List member&#39;s roles
[**getMembers**](MembersApiInterface.md#getMembers) | **GET** /members | List all members
[**mergeMember**](MembersApiInterface.md#mergeMember) | **POST** /members/{memberId}/merge_into/{mergeMemberId} | Merge member
[**patchMemberById**](MembersApiInterface.md#patchMemberById) | **PATCH** /members/{memberId} | Partial Update Member
[**removeMemberRoleById**](MembersApiInterface.md#removeMemberRoleById) | **DELETE** /members/{memberId}/roles/{roleId} | Remove Member Role
[**updateMemberById**](MembersApiInterface.md#updateMemberById) | **PUT** /members/{memberId} | Update Member


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

## **addMemberRoleById**
> OpenAPI\Server\Model\MemberRoleData addMemberRoleById($memberId, $roleId, $memberRoleInput)

Add Member Role

Add Member Role

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
    public function addMemberRoleById(int $memberId, int $roleId, MemberRoleInput $memberRoleInput = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberId** | **int**|  |
 **roleId** | **int**|  |
 **memberRoleInput** | [**OpenAPI\Server\Model\MemberRoleInput**](../Model/MemberRoleInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\MemberRoleData**](../Model/MemberRoleData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

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

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

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
    public function deleteMemberById(int $memberId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getListRulesByMemberId**
> OpenAPI\Server\Model\ListRules getListRulesByMemberId($memberId, $query, $sort, $pageSize, $page)

Get List Rules by Member ID

Get List Rules by Member ID

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
     * Implementation of MembersApiInterface#getListRulesByMemberId
     */
    public function getListRulesByMemberId(int $memberId, string $query = null, string $sort = null, int $pageSize = null, int $page = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberId** | **int**|  |
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

## **getMemberById**
> OpenAPI\Server\Model\MemberData getMemberById($memberId)

Get Member

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
    public function getMemberById(int $memberId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\MemberData**](../Model/MemberData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getMemberContactsById**
> OpenAPI\Server\Model\Contacts getMemberContactsById($memberId, $sort, $pageSize, $page)

List member's contacts

List contacts for this member

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
     * Implementation of MembersApiInterface#getMemberContactsById
     */
    public function getMemberContactsById(int $memberId, string $sort = null, int $pageSize = null, int $page = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberId** | **int**|  |
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

## **getMemberRolesById**
> OpenAPI\Server\Model\MemberRoles getMemberRolesById($memberId, $sort, $pageSize, $page)

List member's roles

List roles for this member

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
     * Implementation of MembersApiInterface#getMemberRolesById
     */
    public function getMemberRolesById(int $memberId, string $sort = null, int $pageSize = null, int $page = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberId** | **int**|  |
 **sort** | **string**|  | [optional]
 **pageSize** | **int**|  | [optional]
 **page** | **int**|  | [optional]

### Return type

[**OpenAPI\Server\Model\MemberRoles**](../Model/MemberRoles.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **getMembers**
> OpenAPI\Server\Model\Members getMembers($query, $sort, $pageSize, $page)

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
    public function getMembers(string $query = null, string $sort = null, int $pageSize = null, int $page = null)
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

[**OpenAPI\Server\Model\Members**](../Model/Members.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

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
    public function mergeMember(int $memberId, int $mergeMemberId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberId** | **int**|  |
 **mergeMemberId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **patchMemberById**
> OpenAPI\Server\Model\MemberData patchMemberById($memberId, $memberInput)

Partial Update Member

Partially update member

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
     * Implementation of MembersApiInterface#patchMemberById
     */
    public function patchMemberById(int $memberId, MemberInput $memberInput = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberId** | **int**|  |
 **memberInput** | [**OpenAPI\Server\Model\MemberInput**](../Model/MemberInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\MemberData**](../Model/MemberData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **removeMemberRoleById**
> OpenAPI\Server\Model\ApiResponse removeMemberRoleById($memberId, $roleId)

Remove Member Role

Remove Member Role

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
    public function removeMemberRoleById(int $memberId, int $roleId)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberId** | **int**|  |
 **roleId** | **int**|  |

### Return type

[**OpenAPI\Server\Model\ApiResponse**](../Model/ApiResponse.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

## **updateMemberById**
> OpenAPI\Server\Model\MemberData updateMemberById($memberId, $memberInput)

Update Member

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
    public function updateMemberById(int $memberId, MemberInput $memberInput = null)
    {
        // Implement the operation ...
    }

    // ...
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **memberId** | **int**|  |
 **memberInput** | [**OpenAPI\Server\Model\MemberInput**](../Model/MemberInput.md)|  | [optional]

### Return type

[**OpenAPI\Server\Model\MemberData**](../Model/MemberData.md)

### Authorization

[contact_auth](../../README.md#contact_auth), [jwt_auth](../../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

