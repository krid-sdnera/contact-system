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

use_ok('WWW::OpenAPIClient::MembersApi');

my $api = WWW::OpenAPIClient::MembersApi->new();
isa_ok($api, 'WWW::OpenAPIClient::MembersApi');

#
# add_member_role_by_id test
#
# uncomment below and update the test
#my $add_member_role_by_id_member_id = undef; # replace NULL with a proper value
#my $add_member_role_by_id_role_id = undef; # replace NULL with a proper value
#my $add_member_role_by_id_member_role_input = undef; # replace NULL with a proper value
#my $add_member_role_by_id_result = $api->add_member_role_by_id(member_id => $add_member_role_by_id_member_id, role_id => $add_member_role_by_id_role_id, member_role_input => $add_member_role_by_id_member_role_input);

#
# create_member test
#
# uncomment below and update the test
#my $create_member_member_input = undef; # replace NULL with a proper value
#my $create_member_result = $api->create_member(member_input => $create_member_member_input);

#
# delete_member_by_id test
#
# uncomment below and update the test
#my $delete_member_by_id_member_id = undef; # replace NULL with a proper value
#my $delete_member_by_id_result = $api->delete_member_by_id(member_id => $delete_member_by_id_member_id);

#
# get_list_rules_by_member_id test
#
# uncomment below and update the test
#my $get_list_rules_by_member_id_member_id = undef; # replace NULL with a proper value
#my $get_list_rules_by_member_id_query = undef; # replace NULL with a proper value
#my $get_list_rules_by_member_id_sort = undef; # replace NULL with a proper value
#my $get_list_rules_by_member_id_page_size = undef; # replace NULL with a proper value
#my $get_list_rules_by_member_id_page = undef; # replace NULL with a proper value
#my $get_list_rules_by_member_id_result = $api->get_list_rules_by_member_id(member_id => $get_list_rules_by_member_id_member_id, query => $get_list_rules_by_member_id_query, sort => $get_list_rules_by_member_id_sort, page_size => $get_list_rules_by_member_id_page_size, page => $get_list_rules_by_member_id_page);

#
# get_member_by_id test
#
# uncomment below and update the test
#my $get_member_by_id_member_id = undef; # replace NULL with a proper value
#my $get_member_by_id_result = $api->get_member_by_id(member_id => $get_member_by_id_member_id);

#
# get_member_contacts_by_id test
#
# uncomment below and update the test
#my $get_member_contacts_by_id_member_id = undef; # replace NULL with a proper value
#my $get_member_contacts_by_id_sort = undef; # replace NULL with a proper value
#my $get_member_contacts_by_id_page_size = undef; # replace NULL with a proper value
#my $get_member_contacts_by_id_page = undef; # replace NULL with a proper value
#my $get_member_contacts_by_id_result = $api->get_member_contacts_by_id(member_id => $get_member_contacts_by_id_member_id, sort => $get_member_contacts_by_id_sort, page_size => $get_member_contacts_by_id_page_size, page => $get_member_contacts_by_id_page);

#
# get_member_roles_by_id test
#
# uncomment below and update the test
#my $get_member_roles_by_id_member_id = undef; # replace NULL with a proper value
#my $get_member_roles_by_id_sort = undef; # replace NULL with a proper value
#my $get_member_roles_by_id_page_size = undef; # replace NULL with a proper value
#my $get_member_roles_by_id_page = undef; # replace NULL with a proper value
#my $get_member_roles_by_id_result = $api->get_member_roles_by_id(member_id => $get_member_roles_by_id_member_id, sort => $get_member_roles_by_id_sort, page_size => $get_member_roles_by_id_page_size, page => $get_member_roles_by_id_page);

#
# get_members test
#
# uncomment below and update the test
#my $get_members_query = undef; # replace NULL with a proper value
#my $get_members_sort = undef; # replace NULL with a proper value
#my $get_members_page_size = undef; # replace NULL with a proper value
#my $get_members_page = undef; # replace NULL with a proper value
#my $get_members_result = $api->get_members(query => $get_members_query, sort => $get_members_sort, page_size => $get_members_page_size, page => $get_members_page);

#
# merge_member test
#
# uncomment below and update the test
#my $merge_member_member_id = undef; # replace NULL with a proper value
#my $merge_member_merge_member_id = undef; # replace NULL with a proper value
#my $merge_member_result = $api->merge_member(member_id => $merge_member_member_id, merge_member_id => $merge_member_merge_member_id);

#
# patch_member_by_id test
#
# uncomment below and update the test
#my $patch_member_by_id_member_id = undef; # replace NULL with a proper value
#my $patch_member_by_id_member_input = undef; # replace NULL with a proper value
#my $patch_member_by_id_result = $api->patch_member_by_id(member_id => $patch_member_by_id_member_id, member_input => $patch_member_by_id_member_input);

#
# remove_member_role_by_id test
#
# uncomment below and update the test
#my $remove_member_role_by_id_member_id = undef; # replace NULL with a proper value
#my $remove_member_role_by_id_role_id = undef; # replace NULL with a proper value
#my $remove_member_role_by_id_result = $api->remove_member_role_by_id(member_id => $remove_member_role_by_id_member_id, role_id => $remove_member_role_by_id_role_id);

#
# update_member_by_id test
#
# uncomment below and update the test
#my $update_member_by_id_member_id = undef; # replace NULL with a proper value
#my $update_member_by_id_member_input = undef; # replace NULL with a proper value
#my $update_member_by_id_result = $api->update_member_by_id(member_id => $update_member_by_id_member_id, member_input => $update_member_by_id_member_input);

