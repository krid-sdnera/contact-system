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

use_ok('WWW::OpenAPIClient::ListsApi');

my $api = WWW::OpenAPIClient::ListsApi->new();
isa_ok($api, 'WWW::OpenAPIClient::ListsApi');

#
# create_list test
#
# uncomment below and update the test
#my $create_list_list_input = undef; # replace NULL with a proper value
#my $create_list_result = $api->create_list(list_input => $create_list_list_input);

#
# create_list_rule_by_list_id test
#
# uncomment below and update the test
#my $create_list_rule_by_list_id_list_id = undef; # replace NULL with a proper value
#my $create_list_rule_by_list_id_list_rule_input = undef; # replace NULL with a proper value
#my $create_list_rule_by_list_id_result = $api->create_list_rule_by_list_id(list_id => $create_list_rule_by_list_id_list_id, list_rule_input => $create_list_rule_by_list_id_list_rule_input);

#
# delete_list_by_id test
#
# uncomment below and update the test
#my $delete_list_by_id_list_id = undef; # replace NULL with a proper value
#my $delete_list_by_id_result = $api->delete_list_by_id(list_id => $delete_list_by_id_list_id);

#
# delete_list_rule_by_list_id test
#
# uncomment below and update the test
#my $delete_list_rule_by_list_id_list_id = undef; # replace NULL with a proper value
#my $delete_list_rule_by_list_id_rule_id = undef; # replace NULL with a proper value
#my $delete_list_rule_by_list_id_result = $api->delete_list_rule_by_list_id(list_id => $delete_list_rule_by_list_id_list_id, rule_id => $delete_list_rule_by_list_id_rule_id);

#
# get_list_by_address test
#
# uncomment below and update the test
#my $get_list_by_address_list_address = undef; # replace NULL with a proper value
#my $get_list_by_address_result = $api->get_list_by_address(list_address => $get_list_by_address_list_address);

#
# get_list_by_id test
#
# uncomment below and update the test
#my $get_list_by_id_list_id = undef; # replace NULL with a proper value
#my $get_list_by_id_result = $api->get_list_by_id(list_id => $get_list_by_id_list_id);

#
# get_list_recipients_by_list_id test
#
# uncomment below and update the test
#my $get_list_recipients_by_list_id_list_id = undef; # replace NULL with a proper value
#my $get_list_recipients_by_list_id_query = undef; # replace NULL with a proper value
#my $get_list_recipients_by_list_id_sort = undef; # replace NULL with a proper value
#my $get_list_recipients_by_list_id_page_size = undef; # replace NULL with a proper value
#my $get_list_recipients_by_list_id_page = undef; # replace NULL with a proper value
#my $get_list_recipients_by_list_id_result = $api->get_list_recipients_by_list_id(list_id => $get_list_recipients_by_list_id_list_id, query => $get_list_recipients_by_list_id_query, sort => $get_list_recipients_by_list_id_sort, page_size => $get_list_recipients_by_list_id_page_size, page => $get_list_recipients_by_list_id_page);

#
# get_list_rule_by_list_id test
#
# uncomment below and update the test
#my $get_list_rule_by_list_id_list_id = undef; # replace NULL with a proper value
#my $get_list_rule_by_list_id_rule_id = undef; # replace NULL with a proper value
#my $get_list_rule_by_list_id_result = $api->get_list_rule_by_list_id(list_id => $get_list_rule_by_list_id_list_id, rule_id => $get_list_rule_by_list_id_rule_id);

#
# get_list_rules_by_list_id test
#
# uncomment below and update the test
#my $get_list_rules_by_list_id_list_id = undef; # replace NULL with a proper value
#my $get_list_rules_by_list_id_query = undef; # replace NULL with a proper value
#my $get_list_rules_by_list_id_sort = undef; # replace NULL with a proper value
#my $get_list_rules_by_list_id_page_size = undef; # replace NULL with a proper value
#my $get_list_rules_by_list_id_page = undef; # replace NULL with a proper value
#my $get_list_rules_by_list_id_result = $api->get_list_rules_by_list_id(list_id => $get_list_rules_by_list_id_list_id, query => $get_list_rules_by_list_id_query, sort => $get_list_rules_by_list_id_sort, page_size => $get_list_rules_by_list_id_page_size, page => $get_list_rules_by_list_id_page);

#
# get_lists test
#
# uncomment below and update the test
#my $get_lists_query = undef; # replace NULL with a proper value
#my $get_lists_sort = undef; # replace NULL with a proper value
#my $get_lists_page_size = undef; # replace NULL with a proper value
#my $get_lists_page = undef; # replace NULL with a proper value
#my $get_lists_result = $api->get_lists(query => $get_lists_query, sort => $get_lists_sort, page_size => $get_lists_page_size, page => $get_lists_page);

#
# update_list_by_id test
#
# uncomment below and update the test
#my $update_list_by_id_list_id = undef; # replace NULL with a proper value
#my $update_list_by_id_list_input = undef; # replace NULL with a proper value
#my $update_list_by_id_result = $api->update_list_by_id(list_id => $update_list_by_id_list_id, list_input => $update_list_by_id_list_input);

#
# update_list_rule_by_list_id test
#
# uncomment below and update the test
#my $update_list_rule_by_list_id_list_id = undef; # replace NULL with a proper value
#my $update_list_rule_by_list_id_rule_id = undef; # replace NULL with a proper value
#my $update_list_rule_by_list_id_list_rule_input = undef; # replace NULL with a proper value
#my $update_list_rule_by_list_id_result = $api->update_list_rule_by_list_id(list_id => $update_list_rule_by_list_id_list_id, rule_id => $update_list_rule_by_list_id_rule_id, list_rule_input => $update_list_rule_by_list_id_list_rule_input);

