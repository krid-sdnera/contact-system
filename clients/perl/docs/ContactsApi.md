# WWW::OpenAPIClient::ContactsApi

## Load the API package
```perl
use WWW::OpenAPIClient::Object::ContactsApi;
```

All URIs are relative to *https://members.mooneevalleyscouts.org.au/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**create_contact**](ContactsApi.md#create_contact) | **POST** /contacts | 
[**delete_contact_by_id**](ContactsApi.md#delete_contact_by_id) | **DELETE** /contacts/{contactId} | 
[**get_contact_by_id**](ContactsApi.md#get_contact_by_id) | **GET** /contacts/{contactId} | Your GET endpoint
[**get_contacts**](ContactsApi.md#get_contacts) | **GET** /contacts | Your GET endpoint
[**patch_contact_by_id**](ContactsApi.md#patch_contact_by_id) | **PATCH** /contacts/{contactId} | 
[**update_contact_by_id**](ContactsApi.md#update_contact_by_id) | **PUT** /contacts/{contactId} | 


# **create_contact**
> ContactData create_contact(contact_input => $contact_input)



createContact

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ContactsApi;
my $api_instance = WWW::OpenAPIClient::ContactsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $contact_input = WWW::OpenAPIClient::Object::ContactInput->new(); # ContactInput | 

eval { 
    my $result = $api_instance->create_contact(contact_input => $contact_input);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ContactsApi->create_contact: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **contact_input** | [**ContactInput**](ContactInput.md)|  | [optional] 

### Return type

[**ContactData**](ContactData.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **delete_contact_by_id**
> ApiResponse delete_contact_by_id(contact_id => $contact_id)



deleteContactById

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ContactsApi;
my $api_instance = WWW::OpenAPIClient::ContactsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $contact_id = 56; # int | 

eval { 
    my $result = $api_instance->delete_contact_by_id(contact_id => $contact_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ContactsApi->delete_contact_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **contact_id** | **int**|  | 

### Return type

[**ApiResponse**](ApiResponse.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_contact_by_id**
> ContactData get_contact_by_id(contact_id => $contact_id)

Your GET endpoint

getContactById

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ContactsApi;
my $api_instance = WWW::OpenAPIClient::ContactsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $contact_id = 56; # int | 

eval { 
    my $result = $api_instance->get_contact_by_id(contact_id => $contact_id);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ContactsApi->get_contact_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **contact_id** | **int**|  | 

### Return type

[**ContactData**](ContactData.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **get_contacts**
> Contacts get_contacts(query => $query, sort => $sort, page_size => $page_size, page => $page)

Your GET endpoint

Your GET endpoint

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ContactsApi;
my $api_instance = WWW::OpenAPIClient::ContactsApi->new(

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
    my $result = $api_instance->get_contacts(query => $query, sort => $sort, page_size => $page_size, page => $page);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ContactsApi->get_contacts: $@\n";
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

[**Contacts**](Contacts.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **patch_contact_by_id**
> ContactData patch_contact_by_id(contact_id => $contact_id, contact_input => $contact_input)



patchContactById

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ContactsApi;
my $api_instance = WWW::OpenAPIClient::ContactsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $contact_id = 56; # int | 
my $contact_input = WWW::OpenAPIClient::Object::ContactInput->new(); # ContactInput | 

eval { 
    my $result = $api_instance->patch_contact_by_id(contact_id => $contact_id, contact_input => $contact_input);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ContactsApi->patch_contact_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **contact_id** | **int**|  | 
 **contact_input** | [**ContactInput**](ContactInput.md)|  | [optional] 

### Return type

[**ContactData**](ContactData.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **update_contact_by_id**
> ContactData update_contact_by_id(contact_id => $contact_id, contact_input => $contact_input)



updateContactById

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::ContactsApi;
my $api_instance = WWW::OpenAPIClient::ContactsApi->new(

    # Configure API key authorization: contact_auth
    api_key => {'x-auth-token' => 'YOUR_API_KEY'},
    # uncomment below to setup prefix (e.g. Bearer) for API key, if needed
    #api_key_prefix => {'x-auth-token' => 'Bearer'},
    # Configure HTTP basic authorization: jwt_auth
    # Configure bearer access token for authorization: jwt_auth
    access_token => 'YOUR_BEARER_TOKEN',
    
);

my $contact_id = 56; # int | 
my $contact_input = WWW::OpenAPIClient::Object::ContactInput->new(); # ContactInput | 

eval { 
    my $result = $api_instance->update_contact_by_id(contact_id => $contact_id, contact_input => $contact_input);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling ContactsApi->update_contact_by_id: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **contact_id** | **int**|  | 
 **contact_input** | [**ContactInput**](ContactInput.md)|  | [optional] 

### Return type

[**ContactData**](ContactData.md)

### Authorization

[contact_auth](../README.md#contact_auth), [jwt_auth](../README.md#jwt_auth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

