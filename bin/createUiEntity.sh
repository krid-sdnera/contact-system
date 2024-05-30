#!/bin/bash

SOURCE=member
# TARGET=contact
# TARGET=role
# TARGET=section
# TARGET=scoutGroup
# TARGET=memberRole
# TARGET=list
# TARGET=listRule
# TARGET=listMember   
exit Entities already created. Be careful

cd "$(dirname -- $(readlink -f "$0"))/../ui"

cp ./composables/${SOURCE}s.ts ./composables/${TARGET}s.ts
cp ./server/types/${SOURCE}.ts ./server/types/${TARGET}.ts
mkdir -p ./pages/${TARGET}s
cp ./pages/${SOURCE}s/*.vue ./pages/${TARGET}s
mkdir -p ./components/${TARGET}s
cp ./components/${SOURCE}s/*.vue ./components/${TARGET}s

sed -i "s/${SOURCE}/${TARGET}/g" ./composables/${TARGET}s.ts
sed -i "s/${SOURCE}/${TARGET}/g" ./server/types/${TARGET}.ts
sed -i "s/${SOURCE}/${TARGET}/g" ./pages/${TARGET}s/*
sed -i "s/${SOURCE}/${TARGET}/g" ./components/${TARGET}s/*

sed -i "s/${SOURCE^}/${TARGET^}/g" ./composables/${TARGET}s.ts
sed -i "s/${SOURCE^}/${TARGET^}/g" ./server/types/${TARGET}.ts
sed -i "s/${SOURCE^}/${TARGET^}/g" ./pages/${TARGET}s/*
sed -i "s/${SOURCE^}/${TARGET^}/g" ./components/${TARGET}s/*
