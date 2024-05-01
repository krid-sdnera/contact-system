#!/bin/bash

SEDOPTION="-i"
if [[ "$OSTYPE" == "darwin"* ]]; then
  SEDOPTION="-i ''"
fi

cd "$(dirname -- $(readlink -f "$0"))/.."

echo "> Remove existing generation"
rm -fr api/lib/ContactSystem/Api/*
rm -fr ui/lib/ContactSystem/Client/*

echo "> Generate Client using openapi-generator generate"
yarn install
yarn run openapi-generator-cli  generate

echo "> Upgrade Composer dependacies"
sed $SEDOPTION -e 's/"jms\/serializer-bundle": "^2.0"/"jms\/serializer-bundle": "^3.0"/' api/lib/ContactSystem/Api/composer.json
sed $SEDOPTION -e 's/"symfony\/framework-bundle": "^4.4.8"/"symfony\/framework-bundle": "^4.4.8|^5.0"/' api/lib/ContactSystem/Api/composer.json

echo "> Remove Deserialization NamingStrategy"
perl -0777 -i -ple '
$old = <<'\''HERE1'\'';
        \$naming_strategy = new SerializedNameAnnotationStrategy\(new CamelCaseNamingStrategy\(\)\);
        \$this->serializer = SerializerBuilder::create\(\)
            ->setDeserializationVisitor\('\''json'\'', new StrictJsonDeserializationVisitor\(\$naming_strategy\)\)
            ->setDeserializationVisitor\('\''xml'\'', new XmlDeserializationVisitor\(\$naming_strategy\)\)
            ->build\(\);
HERE1
$new = << '\''HERE2'\'';
        // TODO: Workout how to specify naming strategy for JSON and XML           
        $this->serializer = SerializerBuilder::create()->build();
HERE2

s/$old/$new/m;
' api/lib/ContactSystem/Api/Service/JmsSerializer.php

echo "> Remove trailing spaces"
sed $SEDOPTION -e 's/return \$this->deserializeString(\$data, \$type);           /return $this->deserializeString($data, $type);/' api/lib/ContactSystem/Api/Service/JmsSerializer.php

echo "> Add Symfony Guard Authenticator support"
perl -0777 -i -ple '
$old = <<'\''HERE1'\'';
use Symfony\\Component\\HttpKernel\\Exception\\HttpException;
HERE1
$new = << '\''HERE2'\'';
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
HERE2

s/$old/$new/m;
' api/lib/ContactSystem/Api/Controller/*.php

perl -0777 -i -ple '
$old = <<'\''HERE1'\'';
        \} catch \(Exception \$fallthrough\) \{
HERE1
$new = << '\''HERE2'\'';
        } catch (AccessDeniedException $accessDenied) {
            // Fall through to Symfony Guard Authenticator by rethrowing
            throw $accessDenied;
        } catch (Exception $fallthrough) {
HERE2

s/$old/$new/mg;
' api/lib/ContactSystem/Api/Controller/*.php

echo "> Fix double escaped regex"
sed $SEDOPTION -e 's/@Assert\\Regex("\/^\\\\d{4}-\\\\d{2}-\\\\d{2}\$\/")/@Assert\\Regex("\/^\\d{4}-\\d{2}-\\d{2}$\/")/' api/lib/ContactSystem/Api/Model/Member*.php

echo "> Adding type assistance to a union type"
sed $SEDOPTION -e 's/return { ...JwtDataToJSON(value), ...JwtErrorDataToJSON(value) };/return { ...JwtDataToJSON(value as JwtData), ...JwtErrorDataToJSON(value as JwtErrorData) };/' ui/lib/ContactSystem/Client/src/models/JwtErrorResponse.ts

echo "> Handle possible undefined fetchApi"
sed $SEDOPTION -e 's/return this.configuration.fetchApi;/return this.configuration.fetchApi!;/' ui/lib/ContactSystem/Client/src/runtime.ts
