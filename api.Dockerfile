FROM node:20-alpine as node

RUN mkdir -p /home/node/app/node_modules && chown -R node:node /home/node/app
WORKDIR /home/node/app

RUN apk add --no-cache perl
RUN apk add --no-cache openjdk11

USER node

COPY --chown=node:node package*.json ./
COPY --chown=node:node contact-system-api.yaml ./
COPY --chown=node:node openapitools.json ./

RUN npm install

RUN ./node_modules/.bin/openapi-generator-cli generate

COPY --chown=node:node build-docker.sh ./

RUN sh ./build-docker.sh



FROM composer:lts as deps
WORKDIR /app

COPY ./api .

COPY --from=node /home/node/app/api/lib ./lib

RUN --mount=type=cache,target=/tmp/cache \
    composer install --no-interaction

RUN --mount=type=cache,target=/tmp/cache \
    composer dump-autoload


FROM php:8.2-apache as final
RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
WORKDIR /app
COPY --chown=www-data:www-data ./api /app

COPY --from=deps /app/vendor/ /app/vendor
COPY --from=node /home/node/app/api/lib /app/lib

RUN php bin/console cache:clear
RUN chmod 777 /app/var/cache

ENV APACHE_DOCUMENT_ROOT /app/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN sed -ri -e 's!AllowOverride None!AllowOverride All!g' /etc/apache2/sites-available/*.conf

USER www-data

# The command 'lexik:jwt:generate-keypair' was added in a 2.11, while we are running 2.09.
#   RUN php bin/console lexik:jwt:generate-keypair
# Use the older style to create the keys.

# Make sure these cert files are generated under the www-data user or www-data has access to them.
RUN mkdir -p config/jwt
RUN openssl genpkey \
    -pass pass:passphrase \
    -out config/jwt/private.pem \
    -aes256 \
    -algorithm rsa \
    -pkeyopt rsa_keygen_bits:4096
RUN openssl pkey \
    -passin pass:passphrase \
    -in config/jwt/private.pem \
    -out config/jwt/public.pem \
    -pubout

