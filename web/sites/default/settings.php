<?php

// @codingStandardsIgnoreFile

/**
 * @file
 * Drupal 8 configuration file.
 */

// Get the path to the parent of docroot.
$application_directory = dirname(DRUPAL_ROOT);
// Config directories.
$settings['config_sync_directory'] = $application_directory . '/config';

// Trusted host patterns are set in dynamically included files below.
$settings['trusted_host_patterns'] = [];


// 'Public files' directory.
$settings['file_public_path'] = 'sites/default/files';
// 'Private files' directory.
$settings['file_private_path'] = 'sites/default/private-files';

// Include the Redis services.yml file. Adjust the path if you installed to a contrib or other subdirectory.
$settings['container_yamls'][] = 'modules/contrib/redis/example.services.yml';

/**
 * By checking $_ENV['LAGOON'] we know if we are on Lagoon.
 */
if (getenv('LAGOON')) {
  // Load Lagoon settings.
  require_once __DIR__ . '/settings.lagoon.php';
}
// Load settings suitable outside of Lagoon (e.g. local development).
else {
  // Default Google Tag Manager Container Environment "non-Live".
  $config['google_tag.container.default_container']['environment_id'] = 'env-19';
  $config['google_tag.container.default_container']['environment_token'] = 'LrgoUUM8BuZax-g62Vi7Yg';

  $local_services = __DIR__ . '/services.local.yml';
  if (file_exists($local_services)) {
    $settings['container_yamls'][] = $local_services;
  }

  // Load local settings file if it exists.
  $local_conf_file_path = __DIR__ . '/settings.local.php';
  if (file_exists($local_conf_file_path)) {
    require_once $local_conf_file_path;
  }
  // Include for settings managed by ddev.
  $ddev_settings = __DIR__ . '/settings.ddev.php';
  $ddev_redis = __DIR__ . '/settings.ddev.redis.php';
  if (getenv('IS_DDEV_PROJECT') == 'true' && is_readable($ddev_settings)) {
    require $ddev_settings;
    // Include settings required for Redis cache.
    if (is_readable($ddev_redis)) {
      require  $ddev_redis;
    }
  }
}
