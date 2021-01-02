#!/bin/bash

cd "$(dirname -- $(readlink -f "$0"))/../.."

echo "> Remove existing generation"
rm -r ui/lib/ContactSystem/Client/*

echo "> Generate Client using openapi-generator generate"
yarn install
yarn run openapi-generator generate -i common/contact-system-api.yaml -g typescript-fetch -o ui/lib/ContactSystem/Client --git-user-id contact-system --git-repo-id ui --additional-properties=npmRepository=contact-system,npmName=ui,supportsES6=true,typescriptThreePlus=true,withInterfaces=true,legacyDiscriminatorBehavior=false

echo "> Adding type assistance to a union type"
sed -i '' -e 's/return { ...JwtDataToJSON(value), ...JwtErrorDataToJSON(value) };/return { ...JwtDataToJSON(value as JwtData), ...JwtErrorDataToJSON(value as JwtErrorData) };/' ui/lib/ContactSystem/Client/src/models/JwtErrorResponse.ts
