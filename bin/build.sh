#!/bin/bash

cd "$(dirname -- $(readlink -f "$0"))/.."

echo "> Remove existing generation"
rm -r lib/ContactSystem/Api/*

echo "> Generate API using openapi-generator generate"
yarn install
yarn run generate-api

echo "> Upgrade Composer dependacies"
sed -i '' -e 's/"jms\/serializer-bundle": "^2.0"/"jms\/serializer-bundle": "^3.0"/' lib/ContactSystem/Api/composer.json
sed -i '' -e 's/"symfony\/framework-bundle": "^3.3\|^4.1"/"symfony\/framework-bundle": "^3.3|^4.1|^5.0"/' lib/ContactSystem/Api/composer.json

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
' lib/ContactSystem/Api/Service/JmsSerializer.php

echo "> Remove trailing spaces"
sed -i '' -e 's/return \$this->deserializeString(\$data, \$type);           /return $this->deserializeString($data, $type);/' lib/ContactSystem/Api/Service/JmsSerializer.php

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
' lib/ContactSystem/Api/Controller/*.php

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
' lib/ContactSystem/Api/Controller/*.php

echo "> Fix double escaped regex"
sed -i '' -e 's/@Assert\\Regex("\/^\\\\d{4}-\\\\d{2}-\\\\d{2}\$\/")/@Assert\\Regex("\/^\\d{4}-\\d{2}-\\d{2}$\/")/' lib/ContactSystem/Api/Model/Member*.php

