# OpenAPIServer
This is the spec for the Constact system API

This [Symfony](https://symfony.com/) bundle is automatically generated by the [OpenAPI Generator](https://openapi-generator.tech) project:

- API version: 1.0.0
- Build package: org.openapitools.codegen.languages.PhpSymfonyServerCodegen

## Requirements

PHP 7.1.3 and later

## Installation & Usage

To install the dependencies via [Composer](http://getcomposer.org/), add the following repository to `composer.json` of your Symfony project:

```json
{
    "repositories": [{
        "type": "path",
        "url": "//Path to your generated openapi bundle"
    }],
}
```

Then run:

```
composer require contact-system/api:dev-master
```

to add the generated openapi bundle as a dependency.

## Tests

To run the unit tests for the generated bundle, first navigate to the directory containing the code, then run the following commands:

```
composer install
./vendor/bin/phpunit
```


## Getting Started

Step 1: Please follow the [installation procedure](#installation--usage) first.

Step 2: Enable the bundle in the kernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new OpenAPI\Server\OpenAPIServerBundle(),
        // ...
    );
}
```

Step 3: Register the routes:

```yaml
# app/config/routing.yml
open_api_server:
    resource: "@OpenAPIServerBundle/Resources/config/routing.yml"
```

Step 4: Implement the API calls:

```php
<?php
// src/Acme/MyBundle/Api/AuditsApiInterface.php

namespace Acme\MyBundle\Api;

use OpenAPI\Server\Api\AuditsApiInterface;

class AuditsApi implements AuditsApiInterface // An interface is autogenerated
{

    /**
     * Configure API key authorization: contact_auth
     */
    public function setcontact_auth($apiKey)
    {
        // Retrieve logged in user from $apiKey ...
    }
    
    /**
     * Implementation of AuditsApiInterface#getAudits
     */
    public function getAudits(string $query = null, string $sort = null, int $pageSize = null, int $page = null)
    {
        // Implement the operation ...
    }

    // Other operation methods ...
}
```

Step 5: Tag your API implementation:

```yaml
# src/Acme/MyBundle/Resources/services.yml
services:
    # ...
    acme.my_bundle.api.audits:
        class: Acme\MyBundle\Api\AuditsApi
        tags:
            - { name: "open_api_server.api", api: "audits" }
    # ...
```

Now you can start using the bundle!


## Documentation for API Endpoints

All URIs are relative to *https://membership.essendonseascouts.org.au/api/v1*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*AuditsApiInterface* | [**getAudits**](Resources/docs/Api/AuditsApiInterface.md#getaudits) | **GET** /audits | Get Audits
*AuthApiInterface* | [**getJWT**](Resources/docs/Api/AuthApiInterface.md#getjwt) | **POST** /auth/token | Get JWT
*AuthApiInterface* | [**refreshJWT**](Resources/docs/Api/AuthApiInterface.md#refreshjwt) | **POST** /auth/token/refresh | Refresh JWT
*ContactsApiInterface* | [**createContact**](Resources/docs/Api/ContactsApiInterface.md#createcontact) | **POST** /contacts | Create Contact
*ContactsApiInterface* | [**deleteContactById**](Resources/docs/Api/ContactsApiInterface.md#deletecontactbyid) | **DELETE** /contacts/{contactId} | Delete Contact By ID
*ContactsApiInterface* | [**getContactById**](Resources/docs/Api/ContactsApiInterface.md#getcontactbyid) | **GET** /contacts/{contactId} | Get Contact By ID
*ContactsApiInterface* | [**getContacts**](Resources/docs/Api/ContactsApiInterface.md#getcontacts) | **GET** /contacts | List Contacts
*ContactsApiInterface* | [**getListRulesByContactId**](Resources/docs/Api/ContactsApiInterface.md#getlistrulesbycontactid) | **GET** /contacts/{contactId}/list-rules | Get List Rules By Contact ID
*ContactsApiInterface* | [**patchContactById**](Resources/docs/Api/ContactsApiInterface.md#patchcontactbyid) | **PATCH** /contacts/{contactId} | Patch Contact By ID
*ContactsApiInterface* | [**updateContactById**](Resources/docs/Api/ContactsApiInterface.md#updatecontactbyid) | **PUT** /contacts/{contactId} | Update Contact By ID
*ListsApiInterface* | [**createList**](Resources/docs/Api/ListsApiInterface.md#createlist) | **POST** /lists | Create List
*ListsApiInterface* | [**createListRuleByListId**](Resources/docs/Api/ListsApiInterface.md#createlistrulebylistid) | **POST** /lists/{listId}/list-rules | Create List Rule By List ID
*ListsApiInterface* | [**deleteListById**](Resources/docs/Api/ListsApiInterface.md#deletelistbyid) | **DELETE** /lists/{listId} | Delete List By ID
*ListsApiInterface* | [**deleteListRuleByListId**](Resources/docs/Api/ListsApiInterface.md#deletelistrulebylistid) | **DELETE** /lists/{listId}/rules/{ruleId} | Delete List Rule By List ID
*ListsApiInterface* | [**getListByAddress**](Resources/docs/Api/ListsApiInterface.md#getlistbyaddress) | **GET** /lists/address/{listAddress} | Get List By Address
*ListsApiInterface* | [**getListById**](Resources/docs/Api/ListsApiInterface.md#getlistbyid) | **GET** /lists/{listId} | Get List By ID
*ListsApiInterface* | [**getListRecipientsByListId**](Resources/docs/Api/ListsApiInterface.md#getlistrecipientsbylistid) | **GET** /lists/{listId}/recipients | Get List Recipients By List ID
*ListsApiInterface* | [**getListRuleByListId**](Resources/docs/Api/ListsApiInterface.md#getlistrulebylistid) | **GET** /lists/{listId}/rules/{ruleId} | Get List Rule By List ID
*ListsApiInterface* | [**getListRulesByListId**](Resources/docs/Api/ListsApiInterface.md#getlistrulesbylistid) | **GET** /lists/{listId}/list-rules | Get List Rules By List ID
*ListsApiInterface* | [**getLists**](Resources/docs/Api/ListsApiInterface.md#getlists) | **GET** /lists | Get Lists
*ListsApiInterface* | [**updateListById**](Resources/docs/Api/ListsApiInterface.md#updatelistbyid) | **PUT** /lists/{listId} | Update List By ID
*ListsApiInterface* | [**updateListRuleByListId**](Resources/docs/Api/ListsApiInterface.md#updatelistrulebylistid) | **PUT** /lists/{listId}/rules/{ruleId} | Update List Rule By List ID
*MembersApiInterface* | [**addMemberRoleById**](Resources/docs/Api/MembersApiInterface.md#addmemberrolebyid) | **PUT** /members/{memberId}/roles/{roleId} | Add Member Role
*MembersApiInterface* | [**createMember**](Resources/docs/Api/MembersApiInterface.md#createmember) | **POST** /members | Create a member
*MembersApiInterface* | [**deleteMemberById**](Resources/docs/Api/MembersApiInterface.md#deletememberbyid) | **DELETE** /members/{memberId} | Delete member
*MembersApiInterface* | [**getListRulesByMemberId**](Resources/docs/Api/MembersApiInterface.md#getlistrulesbymemberid) | **GET** /members/{memberId}/list-rules | Get List Rules by Member ID
*MembersApiInterface* | [**getMemberById**](Resources/docs/Api/MembersApiInterface.md#getmemberbyid) | **GET** /members/{memberId} | Get Member
*MembersApiInterface* | [**getMemberContactsById**](Resources/docs/Api/MembersApiInterface.md#getmembercontactsbyid) | **GET** /members/{memberId}/contacts | List member&#39;s contacts
*MembersApiInterface* | [**getMemberRolesById**](Resources/docs/Api/MembersApiInterface.md#getmemberrolesbyid) | **GET** /members/{memberId}/roles | List member&#39;s roles
*MembersApiInterface* | [**getMembers**](Resources/docs/Api/MembersApiInterface.md#getmembers) | **GET** /members | List all members
*MembersApiInterface* | [**mergeMember**](Resources/docs/Api/MembersApiInterface.md#mergemember) | **POST** /members/{memberId}/merge_into/{mergeMemberId} | Merge member
*MembersApiInterface* | [**patchMemberById**](Resources/docs/Api/MembersApiInterface.md#patchmemberbyid) | **PATCH** /members/{memberId} | Partial Update Member
*MembersApiInterface* | [**removeMemberRoleById**](Resources/docs/Api/MembersApiInterface.md#removememberrolebyid) | **DELETE** /members/{memberId}/roles/{roleId} | Remove Member Role
*MembersApiInterface* | [**updateMemberById**](Resources/docs/Api/MembersApiInterface.md#updatememberbyid) | **PUT** /members/{memberId} | Update Member
*RolesApiInterface* | [**createRole**](Resources/docs/Api/RolesApiInterface.md#createrole) | **POST** /roles | Create role
*RolesApiInterface* | [**deleteRoleById**](Resources/docs/Api/RolesApiInterface.md#deleterolebyid) | **DELETE** /roles/{roleId} | Delete role
*RolesApiInterface* | [**getListRulesByRoleId**](Resources/docs/Api/RolesApiInterface.md#getlistrulesbyroleid) | **GET** /roles/{roleId}/list-rules | List Rules by Role ID
*RolesApiInterface* | [**getMembersByRoleId**](Resources/docs/Api/RolesApiInterface.md#getmembersbyroleid) | **GET** /roles/{roleId}/members | List members by role
*RolesApiInterface* | [**getRoleById**](Resources/docs/Api/RolesApiInterface.md#getrolebyid) | **GET** /roles/{roleId} | Get Role
*RolesApiInterface* | [**getRoles**](Resources/docs/Api/RolesApiInterface.md#getroles) | **GET** /roles | Get roles
*RolesApiInterface* | [**updateRoleById**](Resources/docs/Api/RolesApiInterface.md#updaterolebyid) | **PUT** /roles/{roleId} | Update role
*ScoutGroupsApiInterface* | [**createScoutGroup**](Resources/docs/Api/ScoutGroupsApiInterface.md#createscoutgroup) | **POST** /groups | Create Group
*ScoutGroupsApiInterface* | [**deleteScoutGroupById**](Resources/docs/Api/ScoutGroupsApiInterface.md#deletescoutgroupbyid) | **DELETE** /groups/{scoutGroupId} | Delete Group
*ScoutGroupsApiInterface* | [**getListRulesByScoutGroupId**](Resources/docs/Api/ScoutGroupsApiInterface.md#getlistrulesbyscoutgroupid) | **GET** /groups/{scoutGroupId}/list-rules | Get List Rules By Scout Group ID
*ScoutGroupsApiInterface* | [**getScoutGroupById**](Resources/docs/Api/ScoutGroupsApiInterface.md#getscoutgroupbyid) | **GET** /groups/{scoutGroupId} | Get Group
*ScoutGroupsApiInterface* | [**getScoutGroupSectionsByScoutGroupId**](Resources/docs/Api/ScoutGroupsApiInterface.md#getscoutgroupsectionsbyscoutgroupid) | **GET** /groups/{scoutGroupId}/sections | Get Scout Group Sections By Scout Group ID
*ScoutGroupsApiInterface* | [**getScoutGroups**](Resources/docs/Api/ScoutGroupsApiInterface.md#getscoutgroups) | **GET** /groups | Get Groups
*ScoutGroupsApiInterface* | [**updateScoutGroupById**](Resources/docs/Api/ScoutGroupsApiInterface.md#updatescoutgroupbyid) | **PUT** /groups/{scoutGroupId} | Update Group
*SectionsApiInterface* | [**createSection**](Resources/docs/Api/SectionsApiInterface.md#createsection) | **POST** /sections | Create Section
*SectionsApiInterface* | [**deleteSectionById**](Resources/docs/Api/SectionsApiInterface.md#deletesectionbyid) | **DELETE** /sections/{sectionId} | Delete Section
*SectionsApiInterface* | [**getListRulesBySectionId**](Resources/docs/Api/SectionsApiInterface.md#getlistrulesbysectionid) | **GET** /sections/{sectionId}/list-rules | Get List Rules By Section ID
*SectionsApiInterface* | [**getMembersBySectionId**](Resources/docs/Api/SectionsApiInterface.md#getmembersbysectionid) | **GET** /sections/{sectionId}/members | List members by section
*SectionsApiInterface* | [**getSectionById**](Resources/docs/Api/SectionsApiInterface.md#getsectionbyid) | **GET** /sections/{sectionId} | Get Section
*SectionsApiInterface* | [**getSectionRolesBySectionId**](Resources/docs/Api/SectionsApiInterface.md#getsectionrolesbysectionid) | **GET** /sections/{sectionId}/roles | List Section Roles By Section ID
*SectionsApiInterface* | [**getSections**](Resources/docs/Api/SectionsApiInterface.md#getsections) | **GET** /sections | Get Sections
*SectionsApiInterface* | [**updateSectionById**](Resources/docs/Api/SectionsApiInterface.md#updatesectionbyid) | **PUT** /sections/{sectionId} | Update Section


## Documentation For Models

 - [AddressData](Resources/docs/Model/AddressData.md)
 - [ApiResponse](Resources/docs/Model/ApiResponse.md)
 - [AuditData](Resources/docs/Model/AuditData.md)
 - [Audits](Resources/docs/Model/Audits.md)
 - [ContactData](Resources/docs/Model/ContactData.md)
 - [ContactInput](Resources/docs/Model/ContactInput.md)
 - [ContactOverrideData](Resources/docs/Model/ContactOverrideData.md)
 - [ContactResponse](Resources/docs/Model/ContactResponse.md)
 - [Contacts](Resources/docs/Model/Contacts.md)
 - [JwtData](Resources/docs/Model/JwtData.md)
 - [JwtErrorData](Resources/docs/Model/JwtErrorData.md)
 - [JwtErrorResponse](Resources/docs/Model/JwtErrorResponse.md)
 - [JwtInput](Resources/docs/Model/JwtInput.md)
 - [ListData](Resources/docs/Model/ListData.md)
 - [ListInput](Resources/docs/Model/ListInput.md)
 - [ListResponse](Resources/docs/Model/ListResponse.md)
 - [ListRuleData](Resources/docs/Model/ListRuleData.md)
 - [ListRuleInput](Resources/docs/Model/ListRuleInput.md)
 - [ListRuleResponse](Resources/docs/Model/ListRuleResponse.md)
 - [ListRules](Resources/docs/Model/ListRules.md)
 - [Lists](Resources/docs/Model/Lists.md)
 - [MemberData](Resources/docs/Model/MemberData.md)
 - [MemberInput](Resources/docs/Model/MemberInput.md)
 - [MemberMetaInviteData](Resources/docs/Model/MemberMetaInviteData.md)
 - [MemberOverrideData](Resources/docs/Model/MemberOverrideData.md)
 - [MemberResponse](Resources/docs/Model/MemberResponse.md)
 - [MemberRoleData](Resources/docs/Model/MemberRoleData.md)
 - [MemberRoleInput](Resources/docs/Model/MemberRoleInput.md)
 - [MemberRoleResponse](Resources/docs/Model/MemberRoleResponse.md)
 - [MemberRoles](Resources/docs/Model/MemberRoles.md)
 - [MemberSuggetion](Resources/docs/Model/MemberSuggetion.md)
 - [Members](Resources/docs/Model/Members.md)
 - [RecipientData](Resources/docs/Model/RecipientData.md)
 - [Recipients](Resources/docs/Model/Recipients.md)
 - [RoleData](Resources/docs/Model/RoleData.md)
 - [RoleInput](Resources/docs/Model/RoleInput.md)
 - [RoleResponse](Resources/docs/Model/RoleResponse.md)
 - [Roles](Resources/docs/Model/Roles.md)
 - [ScoutGroupData](Resources/docs/Model/ScoutGroupData.md)
 - [ScoutGroupInput](Resources/docs/Model/ScoutGroupInput.md)
 - [ScoutGroupResponse](Resources/docs/Model/ScoutGroupResponse.md)
 - [ScoutGroups](Resources/docs/Model/ScoutGroups.md)
 - [SectionData](Resources/docs/Model/SectionData.md)
 - [SectionInput](Resources/docs/Model/SectionInput.md)
 - [SectionResponse](Resources/docs/Model/SectionResponse.md)
 - [Sections](Resources/docs/Model/Sections.md)
 - [UserData](Resources/docs/Model/UserData.md)


## Documentation For Authorization


## contact_auth

- **Type**: API key
- **API key parameter name**: x-auth-token
- **Location**: HTTP header

## jwt_auth

- **Type**: HTTP basic authentication


## Author

dirk@arends.com.au


