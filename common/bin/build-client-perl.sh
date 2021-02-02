#!/bin/bash

cd "$(dirname -- $(readlink -f "$0"))/../.."

echo "> Remove existing generation"
rm -r clients/perl/*

echo "> Generate Client using openapi-generator generate"
yarn install
yarn run openapi-generator generate -i common/contact-system-api.yaml -g perl -o clients/perl --git-user-id contact-system --git-repo-id ui --additional-properties=

