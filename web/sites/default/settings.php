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

$settings['install_profile'] = 'minimal';

// Public files directory.
$settings['file_public_path'] = 'sites/default/files';
// Private files directory.
$settings['file_private_path'] = 'sites/default/private-files';

$settings['hash_salt'] = 'qAFNzv5CKdoOx1A6O1HBELEGAJuTbPd2N9nTayafIkzuHWvMaJcO8MXsHP8C24Vb94jorerLjQ';
