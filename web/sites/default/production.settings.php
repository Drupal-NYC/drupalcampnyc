<?php

// @codingStandardsIgnoreFile

/**
 * @file
 * Loaded by lagoon.settings.php in production type environments.
 *
 * This file is loaded before any environment specific settings file.
 *
 * For redirects:
 * @see https://docs.lagoon.sh/resources/faq/#how-do-i-add-a-redirect
 */

// Google Tag Manager Container Environment needs to be on "main".
$config['google_tag.container.default_container']['environment_id'] = 'env-1';
$config['google_tag.container.default_container']['environment_token'] = '97SL-XpUktcsEEswPqBgOA';

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
