# Prepare devenvironment with files for intellisense.

```
npx nuxt prepare

docker run --mount=type=bind,source=/home/darends/coding/projects/contact-system/contact-system/api/,target=/app/ -it composer:lts composer install --no-interaction --no-scripts --ignore-platform-reqs
```

# Initialise database

```
docker compose exec api bash

php bin/console doctrine:schema:create
php bin/console app:user:register admin password testkey
```
