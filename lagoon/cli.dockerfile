FROM uselagoon/php-7.4-cli-drupal:latest

COPY composer.* /app/
COPY assets /app/assets
RUN composer install --no-dev
COPY . /app
RUN mkdir -p -v -m775 /app/web/sites/default/files

WORKDIR /app/web/themes/drupalnyc
yarn install --frozen-lockfile
yarn run build
yarn install  --production --frozen-lockfile


# Define where the Drupal Root is located
ENV WEBROOT=web
