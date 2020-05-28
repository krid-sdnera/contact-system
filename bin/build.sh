#!/bin/bash

rm -r lib/ContactSystem/Api/*

yarn install
yarn run generate-api

sed -i '' -e 's/"jms\/serializer-bundle": "^2.0"/"jms\/serializer-bundle": "^3.0"/' lib/ContactSystem/Api/composer.json
sed -i '' -e 's/"symfony\/framework-bundle": "^3.3\|^4.1"/"symfony\/framework-bundle": "^3.3|^4.1|^5.0"/' lib/ContactSystem/Api/composer.json

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

sed -i '' -e 's/return \$this->deserializeString(\$data, \$type);           /return $this->deserializeString($data, $type);/' lib/ContactSystem/Api/Service/JmsSerializer.php
