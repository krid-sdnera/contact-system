# Prepare devenvironment with files for intellisense.

```
npx nuxt prepare

docker run --mount=type=bind,source=/home/darends/coding/projects/contact-system/contact-system/api/,target=/app/ -it composer:lts composer install --no-interaction --no-scripts --ignore-platform-reqs
```

# Copy generated API clients from containers

```
rm ./api/lib -rf
docker create --name dummy docker.io/library/contact-system-api
docker cp dummy:/app/lib api/
docker rm -f dummy

rm ./ui/lib -rf
docker create --name dummy docker.io/library/contact-system-ui
docker cp dummy:/home/node/app/lib ui/
docker rm -f dummy

TODO: perl instructions
```

# Initialise database

```
docker compose exec api bash

php bin/console doctrine:schema:create
php bin/console app:user:register admin password testkey
```
