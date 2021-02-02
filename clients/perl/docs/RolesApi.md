# WWW::OpenAPIClient::RolesApi

## Load the API package
```perl
use WWW::OpenAPIClient::Object::RolesApi;
```

All URIs are relative to *https://membership.essendonseascouts.org.au/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**create_role**](RolesApi.md#create_role) | **POST** /roles | Create role
[**delete_role_by_id**](RolesApi.md#delete_role_by_id) | **DELETE** /roles/{roleId} | Delete role
[**get_list_rules_by_role_id**](RolesApi.md#get_list_rules_by_role_id) | **GET** /roles/{roleId}/list-rules | List Rules by Role ID
[**get_members_by_role_id**](RolesApi.md#get_members_by_role_id) | **GET** /roles/{roleId}/members | List members by role
[**get_role_by_id**](RolesApi.md#get_role_by_id) | **GET** /roles/{roleId} | Get Role
[**get_roles**](RolesApi.md#get_roles) | **GET** /roles | Get roles
[**update_role_by_id**](RolesApi.md#update_role_by_id) | **PUT** /roles/{roleId} | Update role


# **create_role**
> RoleData create_role(role_input => $role_input)

Create role

Create role

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::RolesApi;
my $api_instance = WWW::OpenAPIClient::RolesApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $role_input = WWW::OpenAPIClient::Object::RoleInput->new(); # RoleInput | 

eval { 
    my $result = $api_instance->create_role(role_input => $role_input);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling RolesApi->create_role: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **role_input** | [**RoleInput**](RoleInput.md)|  | [optional] 

### Return type

[**RoleData**](RoleData.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **delete_role_by_id**
> ApiResponse delete_role_by_id(role_id => $role_id)

Delete role

Delete role

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::RolesApi;
my $api_instance = WWW::OpenAPIClient::RolesApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $role_id = 56; # int | 

eval { 
    my $result = $api_instance->delete_role_by_id(role_id => $role_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling RolesApi->delete_role_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **role_id** | **int**|  | 

### Return type

[**ApiResponse**](ApiResponse.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_list_rules_by_role_id**
> ListRules get_list_rules_by_role_id(role_id => $role_id, query => $query, sort => $sort, page_size => $page_size, page => $page)

List Rules by Role ID

List Rules by Role ID

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::RolesApi;
my $api_instance = WWW::OpenAPIClient::RolesApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $role_id = 56; # int | 
my $query = "query_example"; # string | 
my $sort = "sort_example"; # string | 
my $page_size = 56; # int | 
my $page = 56; # int | 

eval { 
    my $result = $api_instance->get_list_rules_by_role_id(role_id => $role_id, query => $query, sort => $sort, page_size => $page_size, page => $page);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling RolesApi->get_list_rules_by_role_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **role_id** | **int**|  | 
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

# **get_members_by_role_id**
> Members get_members_by_role_id(role_id => $role_id, query => $query, sort => $sort, page_size => $page_size, page => $page)

List members by role

List all members in this role

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::RolesApi;
my $api_instance = WWW::OpenAPIClient::RolesApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $role_id = 56; # int | 
my $query = "query_example"; # string | 
my $sort = "sort_example"; # string | 
my $page_size = 56; # int | 
my $page = 56; # int | 

eval { 
    my $result = $api_instance->get_members_by_role_id(role_id => $role_id, query => $query, sort => $sort, page_size => $page_size, page => $page);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling RolesApi->get_members_by_role_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **role_id** | **int**|  | 
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

# **get_role_by_id**
> RoleData get_role_by_id(role_id => $role_id)

Get Role

Get role

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::RolesApi;
my $api_instance = WWW::OpenAPIClient::RolesApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $role_id = 56; # int | 

eval { 
    my $result = $api_instance->get_role_by_id(role_id => $role_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling RolesApi->get_role_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **role_id** | **int**|  | 

### Return type

[**RoleData**](RoleData.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_roles**
> Roles get_roles(query => $query, sort => $sort, page_size => $page_size, page => $page)

Get roles

Get roles

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::RolesApi;
my $api_instance = WWW::OpenAPIClient::RolesApi->new(

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
    my $result = $api_instance->get_roles(query => $query, sort => $sort, page_size => $page_size, page => $page);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling RolesApi->get_roles: $@\n";
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

[**Roles**](Roles.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **update_role_by_id**
> RoleData update_role_by_id(role_id => $role_id, role_input => $role_input)

Update role

Update role

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::RolesApi;
my $api_instance = WWW::OpenAPIClient::RolesApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $role_id = 56; # int | 
my $role_input = WWW::OpenAPIClient::Object::RoleInput->new(); # RoleInput | 

eval { 
    my $result = $api_instance->update_role_by_id(role_id => $role_id, role_input => $role_input);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling RolesApi->update_role_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **role_id** | **int**|  | 
 **role_input** | [**RoleInput**](RoleInput.md)|  | [optional] 

### Return type

[**RoleData**](RoleData.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

