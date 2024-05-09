# WWW::OpenAPIClient::ScoutGroupsApi

## Load the API package
```perl
use WWW::OpenAPIClient::Object::ScoutGroupsApi;
```

All URIs are relative to *https://membership.essendonseascouts.org.au/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**create_scout_group**](ScoutGroupsApi.md#create_scout_group) | **POST** /groups | Create Group
[**delete_scout_group_by_id**](ScoutGroupsApi.md#delete_scout_group_by_id) | **DELETE** /groups/{scoutGroupId} | Delete Group
[**get_list_rules_by_scout_group_id**](ScoutGroupsApi.md#get_list_rules_by_scout_group_id) | **GET** /groups/{scoutGroupId}/list-rules | Get List Rules By Scout Group ID
[**get_scout_group_by_id**](ScoutGroupsApi.md#get_scout_group_by_id) | **GET** /groups/{scoutGroupId} | Get Group
[**get_scout_group_sections_by_scout_group_id**](ScoutGroupsApi.md#get_scout_group_sections_by_scout_group_id) | **GET** /groups/{scoutGroupId}/sections | Get Scout Group Sections By Scout Group ID
[**get_scout_groups**](ScoutGroupsApi.md#get_scout_groups) | **GET** /groups | Get Groups
[**update_scout_group_by_id**](ScoutGroupsApi.md#update_scout_group_by_id) | **PUT** /groups/{scoutGroupId} | Update Group


# **create_scout_group**
> ScoutGroupResponse create_scout_group(scout_group_input => $scout_group_input)

Create Group

Create Group

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ScoutGroupsApi;
my $api_instance = WWW::OpenAPIClient::ScoutGroupsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $scout_group_input = WWW::OpenAPIClient::Object::ScoutGroupInput->new(); # ScoutGroupInput | 

eval { 
    my $result = $api_instance->create_scout_group(scout_group_input => $scout_group_input);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ScoutGroupsApi->create_scout_group: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **scout_group_input** | [**ScoutGroupInput**](ScoutGroupInput.md)|  | [optional] 

### Return type

[**ScoutGroupResponse**](ScoutGroupResponse.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **delete_scout_group_by_id**
> ApiResponse delete_scout_group_by_id(scout_group_id => $scout_group_id)

Delete Group

Delete Group

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ScoutGroupsApi;
my $api_instance = WWW::OpenAPIClient::ScoutGroupsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $scout_group_id = 56; # int | 

eval { 
    my $result = $api_instance->delete_scout_group_by_id(scout_group_id => $scout_group_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ScoutGroupsApi->delete_scout_group_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **scout_group_id** | **int**|  | 

### Return type

[**ApiResponse**](ApiResponse.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_list_rules_by_scout_group_id**
> ListRules get_list_rules_by_scout_group_id(scout_group_id => $scout_group_id, query => $query, sort => $sort, page_size => $page_size, page => $page)

Get List Rules By Scout Group ID

Get List Rules By Scout Group ID

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ScoutGroupsApi;
my $api_instance = WWW::OpenAPIClient::ScoutGroupsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $scout_group_id = 56; # int | 
my $query = "query_example"; # string | 
my $sort = "sort_example"; # string | 
my $page_size = 56; # int | 
my $page = 56; # int | 

eval { 
    my $result = $api_instance->get_list_rules_by_scout_group_id(scout_group_id => $scout_group_id, query => $query, sort => $sort, page_size => $page_size, page => $page);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ScoutGroupsApi->get_list_rules_by_scout_group_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **scout_group_id** | **int**|  | 
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

# **get_scout_group_by_id**
> ScoutGroupResponse get_scout_group_by_id(scout_group_id => $scout_group_id)

Get Group

Get Group

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ScoutGroupsApi;
my $api_instance = WWW::OpenAPIClient::ScoutGroupsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $scout_group_id = 56; # int | 

eval { 
    my $result = $api_instance->get_scout_group_by_id(scout_group_id => $scout_group_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ScoutGroupsApi->get_scout_group_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **scout_group_id** | **int**|  | 

### Return type

[**ScoutGroupResponse**](ScoutGroupResponse.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_scout_group_sections_by_scout_group_id**
> Sections get_scout_group_sections_by_scout_group_id(scout_group_id => $scout_group_id)

Get Scout Group Sections By Scout Group ID

Get Scout Group Sections By Scout Group ID

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ScoutGroupsApi;
my $api_instance = WWW::OpenAPIClient::ScoutGroupsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $scout_group_id = 56; # int | 

eval { 
    my $result = $api_instance->get_scout_group_sections_by_scout_group_id(scout_group_id => $scout_group_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ScoutGroupsApi->get_scout_group_sections_by_scout_group_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **scout_group_id** | **int**|  | 

### Return type

[**Sections**](Sections.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_scout_groups**
> ScoutGroups get_scout_groups(query => $query, sort => $sort, page_size => $page_size, page => $page)

Get Groups

Get Groups

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ScoutGroupsApi;
my $api_instance = WWW::OpenAPIClient::ScoutGroupsApi->new(

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
    my $result = $api_instance->get_scout_groups(query => $query, sort => $sort, page_size => $page_size, page => $page);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ScoutGroupsApi->get_scout_groups: $@\n";
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

[**ScoutGroups**](ScoutGroups.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **update_scout_group_by_id**
> ScoutGroupResponse update_scout_group_by_id(scout_group_id => $scout_group_id, scout_group_input => $scout_group_input)

Update Group

Update Group

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ScoutGroupsApi;
my $api_instance = WWW::OpenAPIClient::ScoutGroupsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $scout_group_id = 56; # int | 
my $scout_group_input = WWW::OpenAPIClient::Object::ScoutGroupInput->new(); # ScoutGroupInput | 

eval { 
    my $result = $api_instance->update_scout_group_by_id(scout_group_id => $scout_group_id, scout_group_input => $scout_group_input);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ScoutGroupsApi->update_scout_group_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **scout_group_id** | **int**|  | 
 **scout_group_input** | [**ScoutGroupInput**](ScoutGroupInput.md)|  | [optional] 

### Return type

[**ScoutGroupResponse**](ScoutGroupResponse.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

