# WWW::OpenAPIClient::MembersApi

## Load the API package
```perl
use WWW::OpenAPIClient::Object::MembersApi;
```

All URIs are relative to *https://membership.essendonseascouts.org.au/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**add_member_role_by_id**](MembersApi.md#add_member_role_by_id) | **PUT** /members/{memberId}/roles/{roleId} | Add Member Role
[**create_member**](MembersApi.md#create_member) | **POST** /members | Create a member
[**delete_member_by_id**](MembersApi.md#delete_member_by_id) | **DELETE** /members/{memberId} | Delete member
[**get_list_rules_by_member_id**](MembersApi.md#get_list_rules_by_member_id) | **GET** /members/{memberId}/list-rules | Get List Rules by Member ID
[**get_member_by_id**](MembersApi.md#get_member_by_id) | **GET** /members/{memberId} | Get Member
[**get_member_contacts_by_id**](MembersApi.md#get_member_contacts_by_id) | **GET** /members/{memberId}/contacts | List member&#39;s contacts
[**get_member_roles_by_id**](MembersApi.md#get_member_roles_by_id) | **GET** /members/{memberId}/roles | List member&#39;s roles
[**get_members**](MembersApi.md#get_members) | **GET** /members | List all members
[**merge_member**](MembersApi.md#merge_member) | **POST** /members/{memberId}/merge_into/{mergeMemberId} | Merge member
[**patch_member_by_id**](MembersApi.md#patch_member_by_id) | **PATCH** /members/{memberId} | Partial Update Member
[**remove_member_role_by_id**](MembersApi.md#remove_member_role_by_id) | **DELETE** /members/{memberId}/roles/{roleId} | Remove Member Role
[**update_member_by_id**](MembersApi.md#update_member_by_id) | **PUT** /members/{memberId} | Update Member


# **add_member_role_by_id**
> MemberRoleResponse add_member_role_by_id(member_id => $member_id, role_id => $role_id, member_role_input => $member_role_input)

Add Member Role

Add Member Role

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::MembersApi;
my $api_instance = WWW::OpenAPIClient::MembersApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $member_id = 56; # int | 
my $role_id = 56; # int | 
my $member_role_input = WWW::OpenAPIClient::Object::MemberRoleInput->new(); # MemberRoleInput | 

eval { 
    my $result = $api_instance->add_member_role_by_id(member_id => $member_id, role_id => $role_id, member_role_input => $member_role_input);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling MembersApi->add_member_role_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **member_id** | **int**|  | 
 **role_id** | **int**|  | 
 **member_role_input** | [**MemberRoleInput**](MemberRoleInput.md)|  | [optional] 

### Return type

[**MemberRoleResponse**](MemberRoleResponse.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **create_member**
> MemberResponse create_member(member_input => $member_input)

Create a member

Create a member

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::MembersApi;
my $api_instance = WWW::OpenAPIClient::MembersApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $member_input = WWW::OpenAPIClient::Object::MemberInput->new(); # MemberInput | 

eval { 
    my $result = $api_instance->create_member(member_input => $member_input);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling MembersApi->create_member: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **member_input** | [**MemberInput**](MemberInput.md)|  | 

### Return type

[**MemberResponse**](MemberResponse.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **delete_member_by_id**
> ApiResponse delete_member_by_id(member_id => $member_id)

Delete member

Delete a member

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::MembersApi;
my $api_instance = WWW::OpenAPIClient::MembersApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $member_id = 56; # int | 

eval { 
    my $result = $api_instance->delete_member_by_id(member_id => $member_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling MembersApi->delete_member_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **member_id** | **int**|  | 

### Return type

[**ApiResponse**](ApiResponse.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_list_rules_by_member_id**
> ListRules get_list_rules_by_member_id(member_id => $member_id, query => $query, sort => $sort, page_size => $page_size, page => $page)

Get List Rules by Member ID

Get List Rules by Member ID

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::MembersApi;
my $api_instance = WWW::OpenAPIClient::MembersApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $member_id = 56; # int | 
my $query = "query_example"; # string | 
my $sort = "sort_example"; # string | 
my $page_size = 56; # int | 
my $page = 56; # int | 

eval { 
    my $result = $api_instance->get_list_rules_by_member_id(member_id => $member_id, query => $query, sort => $sort, page_size => $page_size, page => $page);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling MembersApi->get_list_rules_by_member_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **member_id** | **int**|  | 
 **query** | **string**|  | [optional] 
 **sort** | **string**|  | [optional] 
 **page_size** | **int**|  | [optional] 
 **page** | **int**|  | [optional] 

### Return type

[**ListRules**](ListRules.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_member_by_id**
> MemberResponse get_member_by_id(member_id => $member_id)

Get Member

Get details for a member

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::MembersApi;
my $api_instance = WWW::OpenAPIClient::MembersApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $member_id = 56; # int | 

eval { 
    my $result = $api_instance->get_member_by_id(member_id => $member_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling MembersApi->get_member_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **member_id** | **int**|  | 

### Return type

[**MemberResponse**](MemberResponse.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_member_contacts_by_id**
> Contacts get_member_contacts_by_id(member_id => $member_id, sort => $sort, page_size => $page_size, page => $page)

List member's contacts

List contacts for this member

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::MembersApi;
my $api_instance = WWW::OpenAPIClient::MembersApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $member_id = 56; # int | 
my $sort = "sort_example"; # string | 
my $page_size = 56; # int | 
my $page = 56; # int | 

eval { 
    my $result = $api_instance->get_member_contacts_by_id(member_id => $member_id, sort => $sort, page_size => $page_size, page => $page);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling MembersApi->get_member_contacts_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **member_id** | **int**|  | 
 **sort** | **string**|  | [optional] 
 **page_size** | **int**|  | [optional] 
 **page** | **int**|  | [optional] 

### Return type

[**Contacts**](Contacts.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_member_roles_by_id**
> MemberRoles get_member_roles_by_id(member_id => $member_id, sort => $sort, page_size => $page_size, page => $page)

List member's roles

List roles for this member

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::MembersApi;
my $api_instance = WWW::OpenAPIClient::MembersApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $member_id = 56; # int | 
my $sort = "sort_example"; # string | 
my $page_size = 56; # int | 
my $page = 56; # int | 

eval { 
    my $result = $api_instance->get_member_roles_by_id(member_id => $member_id, sort => $sort, page_size => $page_size, page => $page);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling MembersApi->get_member_roles_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **member_id** | **int**|  | 
 **sort** | **string**|  | [optional] 
 **page_size** | **int**|  | [optional] 
 **page** | **int**|  | [optional] 

### Return type

[**MemberRoles**](MemberRoles.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_members**
> Members get_members(query => $query, sort => $sort, page_size => $page_size, page => $page)

List all members

List all members

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::MembersApi;
my $api_instance = WWW::OpenAPIClient::MembersApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $query = "query_example"; # string | 
my $sort = "sort_example"; # string | 
my $page_size = 56; # int | 
my $page = 56; # int | 

eval { 
    my $result = $api_instance->get_members(query => $query, sort => $sort, page_size => $page_size, page => $page);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling MembersApi->get_members: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **query** | **string**|  | [optional] 
 **sort** | **string**|  | [optional] 
 **page_size** | **int**|  | [optional] 
 **page** | **int**|  | [optional] 

### Return type

[**Members**](Members.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **merge_member**
> ApiResponse merge_member(member_id => $member_id, merge_member_id => $merge_member_id)

Merge member

Merge member

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::MembersApi;
my $api_instance = WWW::OpenAPIClient::MembersApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $member_id = 56; # int | 
my $merge_member_id = 56; # int | 

eval { 
    my $result = $api_instance->merge_member(member_id => $member_id, merge_member_id => $merge_member_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling MembersApi->merge_member: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **member_id** | **int**|  | 
 **merge_member_id** | **int**|  | 

### Return type

[**ApiResponse**](ApiResponse.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **patch_member_by_id**
> MemberResponse patch_member_by_id(member_id => $member_id, member_input => $member_input)

Partial Update Member

Partially update member

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::MembersApi;
my $api_instance = WWW::OpenAPIClient::MembersApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $member_id = 56; # int | 
my $member_input = WWW::OpenAPIClient::Object::MemberInput->new(); # MemberInput | 

eval { 
    my $result = $api_instance->patch_member_by_id(member_id => $member_id, member_input => $member_input);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling MembersApi->patch_member_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **member_id** | **int**|  | 
 **member_input** | [**MemberInput**](MemberInput.md)|  | [optional] 

### Return type

[**MemberResponse**](MemberResponse.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **remove_member_role_by_id**
> ApiResponse remove_member_role_by_id(member_id => $member_id, role_id => $role_id)

Remove Member Role

Remove Member Role

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::MembersApi;
my $api_instance = WWW::OpenAPIClient::MembersApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $member_id = 56; # int | 
my $role_id = 56; # int | 

eval { 
    my $result = $api_instance->remove_member_role_by_id(member_id => $member_id, role_id => $role_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling MembersApi->remove_member_role_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **member_id** | **int**|  | 
 **role_id** | **int**|  | 

### Return type

[**ApiResponse**](ApiResponse.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **update_member_by_id**
> MemberResponse update_member_by_id(member_id => $member_id, member_input => $member_input)

Update Member

Update member

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::MembersApi;
my $api_instance = WWW::OpenAPIClient::MembersApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $member_id = 56; # int | 
my $member_input = WWW::OpenAPIClient::Object::MemberInput->new(); # MemberInput | 

eval { 
    my $result = $api_instance->update_member_by_id(member_id => $member_id, member_input => $member_input);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling MembersApi->update_member_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **member_id** | **int**|  | 
 **member_input** | [**MemberInput**](MemberInput.md)|  | [optional] 

### Return type

[**MemberResponse**](MemberResponse.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

