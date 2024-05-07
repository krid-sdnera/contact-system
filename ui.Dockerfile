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



FROM node:20-alpine as final

RUN mkdir -p /home/node/app/node_modules && chown -R node:node /home/node/app

WORKDIR /home/node/app

USER node

COPY --chown=node:node ui/package*.json ./

RUN npm install

COPY --chown=node:node ./ui .
COPY --from=node /home/node/app/ui/lib ./lib

# RUN npx prisma generate

RUN npm run build

EXPOSE 3000

CMD [ "npm", "run", "start-docker" ]
