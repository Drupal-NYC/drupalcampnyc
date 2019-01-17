<?php

/**
 * @file
 * Pantheon additional configuration file.
 */

if (isset($_ENV['PANTHEON_ENVIRONMENT']) && php_sapi_name() != 'cli') {
  // Redirect to https://$primary_domain in the Live environment.
  if ($_ENV['PANTHEON_ENVIRONMENT'] === 'live') {
    $primary_domain = 'www.drupalcamp.nyc/';
  }
  else {
    // Redirect to HTTPS on every Pantheon environment.
    $primary_domain = $_SERVER['HTTP_HOST'];
  }

  if ($_SERVER['HTTP_HOST'] != $primary_domain
    || !isset($_SERVER['HTTP_USER_AGENT_HTTPS'])
    || $_SERVER['HTTP_USER_AGENT_HTTPS'] != 'ON') {

    // Name transaction "redirect" in New Relic for improved reporting (optional).
    if (extension_loaded('newrelic')) {
      newrelic_name_transaction("redirect");
    }

    header('HTTP/1.0 301 Moved Permanently');
    header('Location: https://' . $primary_domain . $_SERVER['REQUEST_URI']);
    exit();
  }
}

if (isset($_ENV['PANTHEON_ENVIRONMENT'])) {

  switch ($_ENV['PANTHEON_ENVIRONMENT']) {
    case 'dev':
      break;

    case 'test':
      break;

    case 'live':
      /*
      if (PHP_SAPI !== 'cli') {
        $settings['config_readonly'] = TRUE;
      }
      */
      $config['config_split.config_split.dev']['status'] = FALSE;
      ini_set('display_errors', '0');
      break;

  }
}
