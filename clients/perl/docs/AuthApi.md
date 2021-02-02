# WWW::OpenAPIClient::AuthApi

## Load the API package
```perl
use WWW::OpenAPIClient::Object::AuthApi;
```

All URIs are relative to *https://membership.essendonseascouts.org.au/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**get_jwt**](AuthApi.md#get_jwt) | **POST** /auth/token | Get JWT
[**refresh_jwt**](AuthApi.md#refresh_jwt) | **POST** /auth/token/refresh | Refresh JWT


# **get_jwt**
> JwtErrorResponse get_jwt(jwt_input => $jwt_input)

Get JWT

Get a JWT

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::AuthApi;
my $api_instance = WWW::OpenAPIClient::AuthApi->new(
);

my $jwt_input = WWW::OpenAPIClient::Object::JwtInput->new(); # JwtInput | 

eval { 
    my $result = $api_instance->get_jwt(jwt_input => $jwt_input);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling AuthApi->get_jwt: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **jwt_input** | [**JwtInput**](JwtInput.md)|  | [optional] 

### Return type

[**JwtErrorResponse**](JwtErrorResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

# **refresh_jwt**
> JwtErrorResponse refresh_jwt(refresh_token => $refresh_token)

Refresh JWT

Refresh a JWT

### Example 
```perl
use Data::Dumper;
use WWW::OpenAPIClient::AuthApi;
my $api_instance = WWW::OpenAPIClient::AuthApi->new(
);

my $refresh_token = "refresh_token_example"; # string | The refresh token

eval { 
    my $result = $api_instance->refresh_jwt(refresh_token => $refresh_token);
    print Dumper($result);
};
if ($@) {
    warn "Exception when calling AuthApi->refresh_jwt: $@\n";
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **refresh_token** | **string**| The refresh token | 

### Return type

[**JwtErrorResponse**](JwtErrorResponse.md)

### Authorization

No authorization required

### HTTP request headers

 - **Content-Type**: application/x-www-form-urlencoded
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../README.md#documentation-for-api-endpoints) [[Back to Model list]](../README.md#documentation-for-models) [[Back to README]](../README.md)

