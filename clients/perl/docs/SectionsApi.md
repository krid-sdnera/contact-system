# WWW::OpenAPIClient::SectionsApi

## Load the API package
```perl
use WWW::OpenAPIClient::Object::SectionsApi;
```

All URIs are relative to *https://membership.essendonseascouts.org.au/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**create_section**](SectionsApi.md#create_section) | **POST** /sections | Create Section
[**delete_section_by_id**](SectionsApi.md#delete_section_by_id) | **DELETE** /sections/{sectionId} | Delete Section
[**get_list_rules_by_section_id**](SectionsApi.md#get_list_rules_by_section_id) | **GET** /sections/{sectionId}/list-rules | Get List Rules By Section ID
[**get_members_by_section_id**](SectionsApi.md#get_members_by_section_id) | **GET** /sections/{sectionId}/members | List members by section
[**get_section_by_id**](SectionsApi.md#get_section_by_id) | **GET** /sections/{sectionId} | Get Section
[**get_section_roles_by_section_id**](SectionsApi.md#get_section_roles_by_section_id) | **GET** /sections/{sectionId}/roles | List Section Roles By Section ID
[**get_sections**](SectionsApi.md#get_sections) | **GET** /sections | Get Sections
[**update_section_by_id**](SectionsApi.md#update_section_by_id) | **PUT** /sections/{sectionId} | Update Section


# **create_section**
> SectionResponse create_section(section_input => $section_input)

Create Section

Create Section

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::SectionsApi;
my $api_instance = WWW::OpenAPIClient::SectionsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $section_input = WWW::OpenAPIClient::Object::SectionInput->new(); # SectionInput | 

eval { 
    my $result = $api_instance->create_section(section_input => $section_input);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling SectionsApi->create_section: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **section_input** | [**SectionInput**](SectionInput.md)|  | [optional] 

### Return type

[**SectionResponse**](SectionResponse.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **delete_section_by_id**
> ApiResponse delete_section_by_id(section_id => $section_id)

Delete Section

Delete Section

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::SectionsApi;
my $api_instance = WWW::OpenAPIClient::SectionsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $section_id = 56; # int | 

eval { 
    my $result = $api_instance->delete_section_by_id(section_id => $section_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling SectionsApi->delete_section_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **section_id** | **int**|  | 

### Return type

[**ApiResponse**](ApiResponse.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_list_rules_by_section_id**
> ListRules get_list_rules_by_section_id(section_id => $section_id, query => $query, sort => $sort, page_size => $page_size, page => $page)

Get List Rules By Section ID

Get List Rules By Section ID

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::SectionsApi;
my $api_instance = WWW::OpenAPIClient::SectionsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $section_id = 56; # int | 
my $query = "query_example"; # string | 
my $sort = "sort_example"; # string | 
my $page_size = 56; # int | 
my $page = 56; # int | 

eval { 
    my $result = $api_instance->get_list_rules_by_section_id(section_id => $section_id, query => $query, sort => $sort, page_size => $page_size, page => $page);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling SectionsApi->get_list_rules_by_section_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **section_id** | **int**|  | 
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

# **get_members_by_section_id**
> Members get_members_by_section_id(section_id => $section_id, query => $query, sort => $sort, page_size => $page_size, page => $page)

List members by section

List all members in this section

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::SectionsApi;
my $api_instance = WWW::OpenAPIClient::SectionsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $section_id = 56; # int | 
my $query = "query_example"; # string | 
my $sort = "sort_example"; # string | 
my $page_size = 56; # int | 
my $page = 56; # int | 

eval { 
    my $result = $api_instance->get_members_by_section_id(section_id => $section_id, query => $query, sort => $sort, page_size => $page_size, page => $page);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling SectionsApi->get_members_by_section_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **section_id** | **int**|  | 
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

# **get_section_by_id**
> SectionResponse get_section_by_id(section_id => $section_id)

Get Section

Get Section

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::SectionsApi;
my $api_instance = WWW::OpenAPIClient::SectionsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $section_id = 56; # int | 

eval { 
    my $result = $api_instance->get_section_by_id(section_id => $section_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling SectionsApi->get_section_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **section_id** | **int**|  | 

### Return type

[**SectionResponse**](SectionResponse.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_section_roles_by_section_id**
> Roles get_section_roles_by_section_id(section_id => $section_id)

List Section Roles By Section ID

List Section Roles By Section ID

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::SectionsApi;
my $api_instance = WWW::OpenAPIClient::SectionsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $section_id = 56; # int | 

eval { 
    my $result = $api_instance->get_section_roles_by_section_id(section_id => $section_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling SectionsApi->get_section_roles_by_section_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **section_id** | **int**|  | 

### Return type

[**Roles**](Roles.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_sections**
> Sections get_sections(query => $query, sort => $sort, page_size => $page_size, page => $page)

Get Sections

Get Sections

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::SectionsApi;
my $api_instance = WWW::OpenAPIClient::SectionsApi->new(

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
    my $result = $api_instance->get_sections(query => $query, sort => $sort, page_size => $page_size, page => $page);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling SectionsApi->get_sections: $@\n";
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

[**Sections**](Sections.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **update_section_by_id**
> SectionResponse update_section_by_id(section_id => $section_id, section_input => $section_input)

Update Section

Update Section

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::SectionsApi;
my $api_instance = WWW::OpenAPIClient::SectionsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $section_id = 56; # int | 
my $section_input = WWW::OpenAPIClient::Object::SectionInput->new(); # SectionInput | 

eval { 
    my $result = $api_instance->update_section_by_id(section_id => $section_id, section_input => $section_input);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling SectionsApi->update_section_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **section_id** | **int**|  | 
 **section_input** | [**SectionInput**](SectionInput.md)|  | [optional] 

### Return type

[**SectionResponse**](SectionResponse.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

