#!/bin/bash

cd "$(dirname -- $(readlink -f "$0"))/../.."

echo "> Removing old database"
rm api/var/data.db
echo "> Initialising new database"
api/bin/console doctrine:database:create
api/bin/console doctrine:schema:create
echo "< New database initialised"

echo "> Setting up test user"

api/bin/console doctrine:query:sql 'INSERT INTO "main"."user" ("id", "username", "roles", "password", "auth_token") VALUES ('\''1'\'', '\''admin'\'', '\''[]'\'', '\''$argon2id$v=19$m=65536,t=4,p=1$2O1RjPedpCL9EbsfV4WRtg$GlRt5N5fYqUh4BdXzzzt5o6LzmP2BC+F0Wwl2y0yhI8'\'', '\''testkey'\'');'

echo "< Test user created"
