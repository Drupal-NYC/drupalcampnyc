<?php

/**
 * @file
 * Pantheon additional configuration file.
 */

// @codingStandardsIgnoreFile

if (isset($_ENV['PANTHEON_ENVIRONMENT']) && php_sapi_name() != 'cli') {
  // Redirect to https://$primary_domain in the Live environment.
  if ($_ENV['PANTHEON_ENVIRONMENT'] === 'live') {
    $primary_domain = 'www.drupalcamp.nyc';
  }
  else {
    // Redirect to HTTPS on every Pantheon environment.
    $primary_domain = $_SERVER['HTTP_HOST'];
  }

  if ($_SERVER['HTTP_HOST'] != $primary_domain
    || !isset($_SERVER['HTTP_USER_AGENT_HTTPS'])
    || $_SERVER['HTTP_USER_AGENT_HTTPS'] != 'ON') {

    // Name transaction "redirect" in New Relic: improved reporting (optional).
    if (extension_loaded('newrelic')) {
      newrelic_name_transaction("redirect");
    }

    header('HTTP/1.0 301 Moved Permanently');
    header('Location: https://' . $primary_domain . $_SERVER['REQUEST_URI']);
    exit();
  }
  // Drupal 8 Trusted Host Settings.
  if (isset($settings) && is_array($settings)) {
    $settings['trusted_host_patterns'] = ['^' . preg_quote($primary_domain) . '$'];
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

//if (defined('PANTHEON_ENVIRONMENT')) {
//  // Include the Redis services.yml file. Adjust the path if you installed to a contrib or other subdirectory.
//  $settings['container_yamls'][] = 'modules/contrib/redis/example.services.yml';
//
//  //phpredis is built into the Pantheon application container.
//  $settings['redis.connection']['interface'] = 'PhpRedis';
//  // These are dynamic variables handled by Pantheon.
//  $settings['redis.connection']['host']      = $_ENV['CACHE_HOST'];
//  $settings['redis.connection']['port']      = $_ENV['CACHE_PORT'];
//  $settings['redis.connection']['password']  = $_ENV['CACHE_PASSWORD'];
//
//  $settings['cache']['default'] = 'cache.backend.redis'; // Use Redis as the default cache.
//  $settings['cache_prefix']['default'] = 'pantheon-redis';
//
//  // Set Redis to not get the cache_form (no performance difference).
//  $settings['cache']['bins']['form']      = 'cache.backend.database';
//}
