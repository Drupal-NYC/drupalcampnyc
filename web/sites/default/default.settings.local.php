<?php

/**
 * @file
 * My local configuration file... *sigh*!
 */

#$settings['container_yamls'][] = $app_root . '/' . $site_path . '/services.yml';
$settings['container_yamls'][] = DRUPAL_ROOT . '/sites/development.services.yml';

// Disable render caches, necessary for twig files to be
// reloaded on every page view.
$settings['cache']['bins']['render'] = 'cache.backend.null';
$settings['cache']['bins']['dynamic_page_cache'] = 'cache.backend.null';
$settings['cache']['bins']['page'] = 'cache.backend.null';

//$databases['default']['default'] = [
//  'database' => 'drupal',
//  'username' => 'drupal',
//  'password' => 'drupal',
//  'prefix' => '',
//  'host' => 'mariadb',
//  'port' => '3306',
//  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
//  'driver' => 'mysql',
//];

$settings['trusted_host_patterns'] = [];
$settings['update_free_access'] = false;
$settings['file_scan_ignore_directories'] = [
  'node_modules',
  'bower_components',
];
$settings['entity_update_batch_size'] = 50;

$config['system.performance']['css']['preprocess'] = FALSE;
$config['system.performance']['js']['preprocess'] = FALSE;
