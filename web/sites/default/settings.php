<?php

// @codingStandardsIgnoreFile

/**
 * @file
 * Drupal 8 configuration file.
 */

/**
 * Include the Pantheon-specific settings file.
 *
 * n.b. The settings.pantheon.php file makes some changes
 *      that affect all environments that this site
 *      exists in.  Always include this file, even in
 *      a local development environment, to ensure that
 *      the site settings remain consistent.
 */
include __DIR__ . "/settings.pantheon.php";

/**
 * Place the config directory outside of the Drupal root.
 */
$settings['config_sync_directory'] = '../config';

$local_settings = __DIR__ . '/settings.local.php';

if (file_exists($local_settings)) {
  include $local_settings;
}

$local_services = __DIR__ . '/services.local.yml';

if (file_exists($local_services)) {
  $settings['container_yamls'][] = $local_services;
}

// Public files directory.
$settings['file_public_path'] = 'sites/default/files';
// Private files directory.
$settings['file_private_path'] = 'sites/default/private-files';

$settings['hash_salt'] = 'qAFNzv5CKdoOx1A6O1HBELEGAJuTbPd2N9nTayafIkzuHWvMaJcO8MXsHP8C24Vb94jorerLjQ';

if (defined('PANTHEON_ENVIRONMENT')) {
  switch ($_ENV['PANTHEON_ENVIRONMENT']) {
    case 'dev':
      // Google Tag Manager Container Environment "Dev".
      $config['google_tag.container.default_container']['environment_id'] = 'env-6';
      $config['google_tag.container.default_container']['environment_token'] = 'yTTLjPSSRKmYgMzokq7MsA';
      break;

    case 'test':
      // Google Tag Manager Container Environment "Test".
      $config['google_tag.container.default_container']['environment_id'] = 'env-5';
      $config['google_tag.container.default_container']['environment_token'] = 'd_NFGurg69G7CSIlfeZwrQ';
      break;

    case 'live':
      // Google Tag Manager Container Environment "Live".
      $config['google_tag.container.default_container']['environment_id'] = 'env-1';
      $config['google_tag.container.default_container']['environment_token'] = 'KwMHOkAq9Tuv1BoGue_3Og';
      break;

    default:
      // Google Tag Manager Container Environment "Other".
      $config['google_tag.container.default_container']['environment_id'] = 'env-7';
      $config['google_tag.container.default_container']['environment_token'] = 'RCeOkCkKhSzZumh-hhqhUw';
  }

  // If we're in the Live or Test environments...
  if (in_array($_ENV['PANTHEON_ENVIRONMENT'], ['test', 'live'])) {
    // Disable development modules and config.
    $config['config_split.config_split.development']['status'] = FALSE;

    // If we're using the Drupal UI...
    if (PHP_SAPI !== 'cli') {
      // Don't allow configuration to be modified.
      $settings['config_readonly'] = TRUE;

      // But do allow menus to be reordered.
      $settings['config_readonly_whitelist_patterns'] = [
        'system.menu.*',
      ];
    }
  }
  else {
    // Enable development modules and config.
    $config['config_split.config_split.development']['status'] = TRUE;
  }

  // See https://pantheon.io/docs/redirects
  if (php_sapi_name() != 'cli') {
    // Redirect to https://$primary_domain in the Live environment
    if ($_ENV['PANTHEON_ENVIRONMENT'] === 'live') {
      // Replace www.example.com with your registered domain name.
      $primary_domain = '2020.drupalcamp.nyc';
    }
    else {
      // Redirect to HTTPS on every Pantheon environment.
      $primary_domain = $_SERVER['HTTP_HOST'];
    }

    if ($_SERVER['HTTP_HOST'] != $primary_domain && $_SERVER['HTTP_HOST'] != 'live-drupalcampnyc.pantheonsite.io') {
      // Name transaction "redirect" in New Relic for improved reporting.
      if (extension_loaded('newrelic')) {
        newrelic_name_transaction("redirect");
      }

      // By default, redirect to the request URI.
      $destination = $_SERVER['REQUEST_URI'];

      // Redirect to specific pages for known www requests (some of these can't
      // be handled by the redirect module because of path collisions).
      if ($_SERVER['HTTP_HOST'] == 'www.drupalcamp.nyc') {
        switch ($_SERVER['REQUEST_URI']) {
          case '/node/11': // About
          case '/node/30': // What's Going On
            $destination = '/';
            break;
          case '/contact':
            $destination = '/how-to-sponsor';
            break;
          case '/local-eateries':
          case '/node/5': // Venue
            $destination = '/venue';
            break;
          case '/our-sponsors':
            $destination = '/sponsors';
            break;
          case '/Program':
            $destination = '/program';
            break;
          case '/credit':
            $destination = '/volunteers';
            break;
        }
      }

      header('HTTP/1.0 301 Moved Permanently');
      header('Location: https://' . $primary_domain . $destination);
      exit();
    }
    else {
      // Redirects from the primary domain HTTP to HTTPS are handled by Pantheon
      // via pantheon.yml's "enforce_https" option.
    }

    // Drupal 8 Trusted Host Settings
    $settings['trusted_host_patterns'] = array(
      '^'. preg_quote($primary_domain) .'$',
      '^live-drupalcampnyc.pantheonsite.io$',
    );
  }

  // Include the Redis services.yml file. Adjust the path if you installed to a contrib or other subdirectory.
  $settings['container_yamls'][] = 'modules/contrib/redis/example.services.yml';

  //phpredis is built into the Pantheon application container.
  $settings['redis.connection']['interface'] = 'PhpRedis';
  // These are dynamic variables handled by Pantheon.
  $settings['redis.connection']['host']      = $_ENV['CACHE_HOST'];
  $settings['redis.connection']['port']      = $_ENV['CACHE_PORT'];
  $settings['redis.connection']['password']  = $_ENV['CACHE_PASSWORD'];

  $settings['cache']['default'] = 'cache.backend.redis'; // Use Redis as the default cache.
  $settings['cache_prefix']['default'] = 'pantheon-redis';

  // Set Redis to not get the cache_form (no performance difference).
  $settings['cache']['bins']['form']      = 'cache.backend.database';
}
// Non-Pantheon environments.
else {
  // Enable development modules and config.
  $config['config_split.config_split.development']['status'] = TRUE;

  // Google Tag Manager Container Environment "Other".
  $config['google_tag.container.default_container']['environment_id'] = 'env-7';
  $config['google_tag.container.default_container']['environment_token'] = 'RCeOkCkKhSzZumh-hhqhUw';
}
