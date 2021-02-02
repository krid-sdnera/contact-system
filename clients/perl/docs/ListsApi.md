# WWW::OpenAPIClient::ListsApi

## Load the API package
```perl
use WWW::OpenAPIClient::Object::ListsApi;
```

All URIs are relative to *https://membership.essendonseascouts.org.au/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**create_list**](ListsApi.md#create_list) | **POST** /lists | Create List
[**create_list_rule_by_list_id**](ListsApi.md#create_list_rule_by_list_id) | **POST** /lists/{listId}/list-rules | Create List Rule By List ID
[**delete_list_by_id**](ListsApi.md#delete_list_by_id) | **DELETE** /lists/{listId} | Delete List By ID
[**delete_list_rule_by_list_id**](ListsApi.md#delete_list_rule_by_list_id) | **DELETE** /lists/{listId}/rules/{ruleId} | Delete List Rule By List ID
[**get_list_by_address**](ListsApi.md#get_list_by_address) | **GET** /lists/address/{listAddress} | Get List By Address
[**get_list_by_id**](ListsApi.md#get_list_by_id) | **GET** /lists/{listId} | Get List By ID
[**get_list_recipients_by_list_id**](ListsApi.md#get_list_recipients_by_list_id) | **GET** /lists/{listId}/recipients | Get List Recipients By List ID
[**get_list_rule_by_list_id**](ListsApi.md#get_list_rule_by_list_id) | **GET** /lists/{listId}/rules/{ruleId} | Get List Rule By List ID
[**get_list_rules_by_list_id**](ListsApi.md#get_list_rules_by_list_id) | **GET** /lists/{listId}/list-rules | Get List Rules By List ID
[**get_lists**](ListsApi.md#get_lists) | **GET** /lists | Get Lists
[**update_list_by_id**](ListsApi.md#update_list_by_id) | **PUT** /lists/{listId} | Update List By ID
[**update_list_rule_by_list_id**](ListsApi.md#update_list_rule_by_list_id) | **PUT** /lists/{listId}/rules/{ruleId} | Update List Rule By List ID


# **create_list**
> ListData create_list(list_input => $list_input)

Create List

Create List

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ListsApi;
my $api_instance = WWW::OpenAPIClient::ListsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $list_input = WWW::OpenAPIClient::Object::ListInput->new(); # ListInput | 

eval { 
    my $result = $api_instance->create_list(list_input => $list_input);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->create_list: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **list_input** | [**ListInput**](ListInput.md)|  | [optional] 

### Return type

[**ListData**](ListData.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **create_list_rule_by_list_id**
> ListRuleData create_list_rule_by_list_id(list_id => $list_id, list_rule_input => $list_rule_input)

Create List Rule By List ID

Create List Rule By List ID

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ListsApi;
my $api_instance = WWW::OpenAPIClient::ListsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $list_id = 56; # int | 
my $list_rule_input = WWW::OpenAPIClient::Object::ListRuleInput->new(); # ListRuleInput | 

eval { 
    my $result = $api_instance->create_list_rule_by_list_id(list_id => $list_id, list_rule_input => $list_rule_input);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->create_list_rule_by_list_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **list_id** | **int**|  | 
 **list_rule_input** | [**ListRuleInput**](ListRuleInput.md)|  | [optional] 

### Return type

[**ListRuleData**](ListRuleData.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **delete_list_by_id**
> ApiResponse delete_list_by_id(list_id => $list_id)

Delete List By ID

Delete List By ID

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ListsApi;
my $api_instance = WWW::OpenAPIClient::ListsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $list_id = 56; # int | 

eval { 
    my $result = $api_instance->delete_list_by_id(list_id => $list_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->delete_list_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **list_id** | **int**|  | 

### Return type

[**ApiResponse**](ApiResponse.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **delete_list_rule_by_list_id**
> ApiResponse delete_list_rule_by_list_id(list_id => $list_id, rule_id => $rule_id)

Delete List Rule By List ID

Delete List Rule By List ID

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ListsApi;
my $api_instance = WWW::OpenAPIClient::ListsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $list_id = 56; # int | 
my $rule_id = 56; # int | 

eval { 
    my $result = $api_instance->delete_list_rule_by_list_id(list_id => $list_id, rule_id => $rule_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->delete_list_rule_by_list_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **list_id** | **int**|  | 
 **rule_id** | **int**|  | 

### Return type

[**ApiResponse**](ApiResponse.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_list_by_address**
> ListData get_list_by_address(list_address => $list_address)

Get List By Address

Get List By Address

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ListsApi;
my $api_instance = WWW::OpenAPIClient::ListsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $list_address = "list_address_example"; # string | 

eval { 
    my $result = $api_instance->get_list_by_address(list_address => $list_address);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->get_list_by_address: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **list_address** | **string**|  | 

### Return type

[**ListData**](ListData.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_list_by_id**
> ListData get_list_by_id(list_id => $list_id)

Get List By ID

Get List By ID

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ListsApi;
my $api_instance = WWW::OpenAPIClient::ListsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $list_id = 56; # int | 

eval { 
    my $result = $api_instance->get_list_by_id(list_id => $list_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->get_list_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **list_id** | **int**|  | 

### Return type

[**ListData**](ListData.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_list_recipients_by_list_id**
> Recipients get_list_recipients_by_list_id(list_id => $list_id, query => $query, sort => $sort, page_size => $page_size, page => $page)

Get List Recipients By List ID

Get List Recipients By List ID

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ListsApi;
my $api_instance = WWW::OpenAPIClient::ListsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $list_id = 56; # int | 
my $query = "query_example"; # string | 
my $sort = "sort_example"; # string | 
my $page_size = 56; # int | 
my $page = 56; # int | 

eval { 
    my $result = $api_instance->get_list_recipients_by_list_id(list_id => $list_id, query => $query, sort => $sort, page_size => $page_size, page => $page);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->get_list_recipients_by_list_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **list_id** | **int**|  | 
 **query** | **string**|  | [optional] 
 **sort** | **string**|  | [optional] 
 **page_size** | **int**|  | [optional] 
 **page** | **int**|  | [optional] 

### Return type

[**Recipients**](Recipients.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_list_rule_by_list_id**
> ListRuleData get_list_rule_by_list_id(list_id => $list_id, rule_id => $rule_id)

Get List Rule By List ID

Get List Rule By List ID

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ListsApi;
my $api_instance = WWW::OpenAPIClient::ListsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $list_id = 56; # int | 
my $rule_id = 56; # int | 

eval { 
    my $result = $api_instance->get_list_rule_by_list_id(list_id => $list_id, rule_id => $rule_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->get_list_rule_by_list_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **list_id** | **int**|  | 
 **rule_id** | **int**|  | 

### Return type

[**ListRuleData**](ListRuleData.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_list_rules_by_list_id**
> ListRules get_list_rules_by_list_id(list_id => $list_id, query => $query, sort => $sort, page_size => $page_size, page => $page)

Get List Rules By List ID

Get List Rule By List ID

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ListsApi;
my $api_instance = WWW::OpenAPIClient::ListsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $list_id = 56; # int | 
my $query = "query_example"; # string | 
my $sort = "sort_example"; # string | 
my $page_size = 56; # int | 
my $page = 56; # int | 

eval { 
    my $result = $api_instance->get_list_rules_by_list_id(list_id => $list_id, query => $query, sort => $sort, page_size => $page_size, page => $page);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->get_list_rules_by_list_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **list_id** | **int**|  | 
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

# **get_lists**
> Lists get_lists(query => $query, sort => $sort, page_size => $page_size, page => $page)

Get Lists

Get Lists

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ListsApi;
my $api_instance = WWW::OpenAPIClient::ListsApi->new(

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
    my $result = $api_instance->get_lists(query => $query, sort => $sort, page_size => $page_size, page => $page);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->get_lists: $@\n";
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

[**Lists**](Lists.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **update_list_by_id**
> ListData update_list_by_id(list_id => $list_id, list_input => $list_input)

Update List By ID

Update List By ID

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ListsApi;
my $api_instance = WWW::OpenAPIClient::ListsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $list_id = 56; # int | 
my $list_input = WWW::OpenAPIClient::Object::ListInput->new(); # ListInput | 

eval { 
    my $result = $api_instance->update_list_by_id(list_id => $list_id, list_input => $list_input);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->update_list_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **list_id** | **int**|  | 
 **list_input** | [**ListInput**](ListInput.md)|  | [optional] 

### Return type

[**ListData**](ListData.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **update_list_rule_by_list_id**
> ListRuleData update_list_rule_by_list_id(list_id => $list_id, rule_id => $rule_id, list_rule_input => $list_rule_input)

Update List Rule By List ID

Update List Rule By List ID

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ListsApi;
my $api_instance = WWW::OpenAPIClient::ListsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $list_id = 56; # int | 
my $rule_id = 56; # int | 
my $list_rule_input = WWW::OpenAPIClient::Object::ListRuleInput->new(); # ListRuleInput | 

eval { 
    my $result = $api_instance->update_list_rule_by_list_id(list_id => $list_id, rule_id => $rule_id, list_rule_input => $list_rule_input);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->update_list_rule_by_list_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **list_id** | **int**|  | 
 **rule_id** | **int**|  | 
 **list_rule_input** | [**ListRuleInput**](ListRuleInput.md)|  | [optional] 

### Return type

[**ListRuleData**](ListRuleData.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

