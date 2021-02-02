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

use_ok('WWW::OpenAPIClient::RolesApi');

my $api = WWW::OpenAPIClient::RolesApi->new();
isa_ok($api, 'WWW::OpenAPIClient::RolesApi');

#
# create_role test
#
# uncomment below and update the test
#my $create_role_role_input = undef; # replace NULL with a proper value
#my $create_role_result = $api->create_role(role_input => $create_role_role_input);

#
# delete_role_by_id test
#
# uncomment below and update the test
#my $delete_role_by_id_role_id = undef; # replace NULL with a proper value
#my $delete_role_by_id_result = $api->delete_role_by_id(role_id => $delete_role_by_id_role_id);

#
# get_list_rules_by_role_id test
#
# uncomment below and update the test
#my $get_list_rules_by_role_id_role_id = undef; # replace NULL with a proper value
#my $get_list_rules_by_role_id_query = undef; # replace NULL with a proper value
#my $get_list_rules_by_role_id_sort = undef; # replace NULL with a proper value
#my $get_list_rules_by_role_id_page_size = undef; # replace NULL with a proper value
#my $get_list_rules_by_role_id_page = undef; # replace NULL with a proper value
#my $get_list_rules_by_role_id_result = $api->get_list_rules_by_role_id(role_id => $get_list_rules_by_role_id_role_id, query => $get_list_rules_by_role_id_query, sort => $get_list_rules_by_role_id_sort, page_size => $get_list_rules_by_role_id_page_size, page => $get_list_rules_by_role_id_page);

#
# get_members_by_role_id test
#
# uncomment below and update the test
#my $get_members_by_role_id_role_id = undef; # replace NULL with a proper value
#my $get_members_by_role_id_query = undef; # replace NULL with a proper value
#my $get_members_by_role_id_sort = undef; # replace NULL with a proper value
#my $get_members_by_role_id_page_size = undef; # replace NULL with a proper value
#my $get_members_by_role_id_page = undef; # replace NULL with a proper value
#my $get_members_by_role_id_result = $api->get_members_by_role_id(role_id => $get_members_by_role_id_role_id, query => $get_members_by_role_id_query, sort => $get_members_by_role_id_sort, page_size => $get_members_by_role_id_page_size, page => $get_members_by_role_id_page);

#
# get_role_by_id test
#
# uncomment below and update the test
#my $get_role_by_id_role_id = undef; # replace NULL with a proper value
#my $get_role_by_id_result = $api->get_role_by_id(role_id => $get_role_by_id_role_id);

#
# get_roles test
#
# uncomment below and update the test
#my $get_roles_query = undef; # replace NULL with a proper value
#my $get_roles_sort = undef; # replace NULL with a proper value
#my $get_roles_page_size = undef; # replace NULL with a proper value
#my $get_roles_page = undef; # replace NULL with a proper value
#my $get_roles_result = $api->get_roles(query => $get_roles_query, sort => $get_roles_sort, page_size => $get_roles_page_size, page => $get_roles_page);

#
# update_role_by_id test
#
# uncomment below and update the test
#my $update_role_by_id_role_id = undef; # replace NULL with a proper value
#my $update_role_by_id_role_input = undef; # replace NULL with a proper value
#my $update_role_by_id_result = $api->update_role_by_id(role_id => $update_role_by_id_role_id, role_input => $update_role_by_id_role_input);

