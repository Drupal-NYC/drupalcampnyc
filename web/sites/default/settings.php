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
