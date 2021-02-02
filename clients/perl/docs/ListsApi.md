# WWW::OpenAPIClient::ListsApi

## Load the API package
```perl
use WWW::OpenAPIClient::Object::ListsApi;
```

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**create_list**](ListsApi.md#create_list) | **POST** /lists | 
[**create_list_rule_by_id**](ListsApi.md#create_list_rule_by_id) | **POST** /lists/{listId}/rules | 
[**create_list_types**](ListsApi.md#create_list_types) | **POST** /lists/types | 
[**delete_list_by_id**](ListsApi.md#delete_list_by_id) | **DELETE** /lists/{listId} | 
[**delete_list_rule_by_id**](ListsApi.md#delete_list_rule_by_id) | **DELETE** /lists/{listId}/rules/{ruleId} | 
[**delete_list_type_by_id**](ListsApi.md#delete_list_type_by_id) | **DELETE** /lists/types/{listTypeId} | 
[**get_list_by_id**](ListsApi.md#get_list_by_id) | **GET** /lists/{listId} | Your GET endpoint
[**get_list_members_by_id**](ListsApi.md#get_list_members_by_id) | **GET** /lists/{listId}/members | Your GET endpoint
[**get_list_rule_by_id**](ListsApi.md#get_list_rule_by_id) | **GET** /lists/{listId}/rules/{ruleId} | Your GET endpoint
[**get_list_rules_by_id**](ListsApi.md#get_list_rules_by_id) | **GET** /lists/{listId}/rules | Your GET endpoint
[**get_list_type_by_id**](ListsApi.md#get_list_type_by_id) | **GET** /lists/types/{listTypeId} | Your GET endpoint
[**get_list_types**](ListsApi.md#get_list_types) | **GET** /lists/types | Your GET endpoint
[**get_lists**](ListsApi.md#get_lists) | **GET** /lists | Your GET endpoint
[**update_list_by_id**](ListsApi.md#update_list_by_id) | **PUT** /lists/{listId} | 
[**update_list_rule_by_id**](ListsApi.md#update_list_rule_by_id) | **PUT** /lists/{listId}/rules/{ruleId} | 
[**update_list_type_by_id**](ListsApi.md#update_list_type_by_id) | **PUT** /lists/types/{listTypeId} | 


# **create_list**
> List create_list(list => $list)



createList

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

my $list = WWW::OpenAPIClient::Object::List->new(); # List | 

eval { 
    my $result = $api_instance->create_list(list => $list);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->create_list: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **list** | [**List**](List.md)|  | [optional] 

### Return type

[**List**](List.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **create_list_rule_by_id**
> ListRule create_list_rule_by_id(list_id => $list_id, list_rule => $list_rule)



createListRuleById

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
my $list_rule = WWW::OpenAPIClient::Object::ListRule->new(); # ListRule | 

eval { 
    my $result = $api_instance->create_list_rule_by_id(list_id => $list_id, list_rule => $list_rule);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->create_list_rule_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **list_id** | **int**|  | 
 **list_rule** | [**ListRule**](ListRule.md)|  | [optional] 

### Return type

[**ListRule**](ListRule.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **create_list_types**
> ListType create_list_types(list_type => $list_type)



createListTypes

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

my $list_type = WWW::OpenAPIClient::Object::ListType->new(); # ListType | 

eval { 
    my $result = $api_instance->create_list_types(list_type => $list_type);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->create_list_types: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **list_type** | [**ListType**](ListType.md)|  | [optional] 

### Return type

[**ListType**](ListType.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **delete_list_by_id**
> ApiResponse delete_list_by_id(list_id => $list_id)



deleteListById

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

# **delete_list_rule_by_id**
> ApiResponse delete_list_rule_by_id(list_id => $list_id, rule_id => $rule_id)



deleteListRuleById

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
    my $result = $api_instance->delete_list_rule_by_id(list_id => $list_id, rule_id => $rule_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->delete_list_rule_by_id: $@\n";
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

# **delete_list_type_by_id**
> ApiResponse delete_list_type_by_id(list_type_id => $list_type_id)



deleteListTypeById

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

my $list_type_id = 56; # int | 

eval { 
    my $result = $api_instance->delete_list_type_by_id(list_type_id => $list_type_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->delete_list_type_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **list_type_id** | **int**|  | 

### Return type

[**ApiResponse**](ApiResponse.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_list_by_id**
> List get_list_by_id(list_id => $list_id)

Your GET endpoint

getListById

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

[**List**](List.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_list_members_by_id**
> ARRAY[MemberData] get_list_members_by_id(list_id => $list_id)

Your GET endpoint

getListMembersById

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
    my $result = $api_instance->get_list_members_by_id(list_id => $list_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->get_list_members_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **list_id** | **int**|  | 

### Return type

[**ARRAY[MemberData]**](MemberData.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_list_rule_by_id**
> ListRule get_list_rule_by_id(list_id => $list_id, rule_id => $rule_id)

Your GET endpoint

getListRuleById

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
    my $result = $api_instance->get_list_rule_by_id(list_id => $list_id, rule_id => $rule_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->get_list_rule_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **list_id** | **int**|  | 
 **rule_id** | **int**|  | 

### Return type

[**ListRule**](ListRule.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_list_rules_by_id**
> ARRAY[ListRule] get_list_rules_by_id(list_id => $list_id)

Your GET endpoint

getListRulesById

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
    my $result = $api_instance->get_list_rules_by_id(list_id => $list_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->get_list_rules_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **list_id** | **int**|  | 

### Return type

[**ARRAY[ListRule]**](ListRule.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_list_type_by_id**
> ListType get_list_type_by_id(list_type_id => $list_type_id)

Your GET endpoint

getListTypeById

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

my $list_type_id = 56; # int | 

eval { 
    my $result = $api_instance->get_list_type_by_id(list_type_id => $list_type_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->get_list_type_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **list_type_id** | **int**|  | 

### Return type

[**ListType**](ListType.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_list_types**
> ARRAY[ListType] get_list_types(query => $query, sort => $sort, page_size => $page_size, page => $page)

Your GET endpoint

getListTypes

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
    my $result = $api_instance->get_list_types(query => $query, sort => $sort, page_size => $page_size, page => $page);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->get_list_types: $@\n";
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

[**ARRAY[ListType]**](ListType.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_lists**
> ARRAY[List] get_lists(query => $query, sort => $sort, page_size => $page_size, page => $page)

Your GET endpoint

getLists

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

[**ARRAY[List]**](List.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **update_list_by_id**
> List update_list_by_id(list_id => $list_id, list => $list)



updateListById

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
my $list = WWW::OpenAPIClient::Object::List->new(); # List | 

eval { 
    my $result = $api_instance->update_list_by_id(list_id => $list_id, list => $list);
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
 **list** | [**List**](List.md)|  | [optional] 

### Return type

[**List**](List.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **update_list_rule_by_id**
> ListRule update_list_rule_by_id(list_id => $list_id, rule_id => $rule_id, list_rule => $list_rule)



updateListRuleById

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
my $list_rule = WWW::OpenAPIClient::Object::ListRule->new(); # ListRule | 

eval { 
    my $result = $api_instance->update_list_rule_by_id(list_id => $list_id, rule_id => $rule_id, list_rule => $list_rule);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->update_list_rule_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **list_id** | **int**|  | 
 **rule_id** | **int**|  | 
 **list_rule** | [**ListRule**](ListRule.md)|  | [optional] 

### Return type

[**ListRule**](ListRule.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **update_list_type_by_id**
> ListType update_list_type_by_id(list_type_id => $list_type_id, list_type => $list_type)



updateListTypeById

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

my $list_type_id = 56; # int | 
my $list_type = WWW::OpenAPIClient::Object::ListType->new(); # ListType | 

eval { 
    my $result = $api_instance->update_list_type_by_id(list_type_id => $list_type_id, list_type => $list_type);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ListsApi->update_list_type_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **list_type_id** | **int**|  | 
 **list_type** | [**ListType**](ListType.md)|  | [optional] 

### Return type

[**ListType**](ListType.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

