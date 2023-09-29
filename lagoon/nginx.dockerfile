ARG CLI_IMAGE
FROM ${CLI_IMAGE} as cli

FROM uselagoon/nginx-drupal:latest

RUN echo "~^drupalnyc.org http://www.drupalnyc.org\$request_uri;" >> /etc/nginx/redirects-map.conf

COPY --from=cli /app /app

# Define where the Drupal Root is located
ENV WEBROOT=web
