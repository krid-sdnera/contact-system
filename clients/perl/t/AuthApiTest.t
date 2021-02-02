=begin comment

Contact System API

This is the spec for the Constact system API

The version of the OpenAPI document: 1.0.0
Contact: dirk@arends.com.au
Generated by: https://openapi-generator.tech

=end comment

=cut

#
# NOTE: This class is auto generated by OpenAPI Generator
# Please update the test cases below to test the API endpoints.
# Ref: https://openapi-generator.tech
#
use Test::More tests => 1; #TODO update number of test cases
use Test::Exception;

use lib 'lib';
use strict;
use warnings;

use_ok('WWW::OpenAPIClient::AuthApi');

my $api = WWW::OpenAPIClient::AuthApi->new();
isa_ok($api, 'WWW::OpenAPIClient::AuthApi');

#
# get_jwt test
#
# uncomment below and update the test
#my $get_jwt_jwt_input = undef; # replace NULL with a proper value
#my $get_jwt_result = $api->get_jwt(jwt_input => $get_jwt_jwt_input);

#
# refresh_jwt test
#
# uncomment below and update the test
#my $refresh_jwt_refresh_token = undef; # replace NULL with a proper value
#my $refresh_jwt_result = $api->refresh_jwt(refresh_token => $refresh_jwt_refresh_token);

