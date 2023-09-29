ARG CLI_IMAGE
FROM ${CLI_IMAGE} as cli

FROM uselagoon/solr-8-drupal:latest

COPY --from=cli /app/web/modules/contrib/search_api_solr/jump-start/solr8/config-set/ /solr-conf/conf

CMD solr-recreate drupal /solr-conf && solr-foreground
