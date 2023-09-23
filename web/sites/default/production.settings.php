<?php&#10&#10// @codingStandardsIgnoreFile&#10&#10/**&#10 * @file&#10 * Loaded by lagoon.settings.php in production type environments.&#10 *&#10 * This file is loaded before any environment specific settings file.&#10 *&#10 * For redirects:&#10 * @see https://docs.lagoon.sh/resources/faq/#how-do-i-add-a-redirect&#10 */&#10&#10// Google Tag Manager Container Environment needs to be on "main".&#10$config['google_tag.container.default_container']['environment_id'] = 'env-1';&#10$config['google_tag.container.default_container']['environment_token'] = '97SL-XpUktcsEEswPqBgOA';&#10&#10// Disable development modules and config.&#10$config['config_split.config_split.development']['status'] = FALSE;&#10&#10// If we're using the Drupal UI...&#10if (PHP_SAPI !== 'cli') {&#10  // Don't allow configuration to be modified.&#10  $settings['config_readonly'] = TRUE;&#10&#10  // But do allow menus to be reordered.&#10  $settings['config_readonly_whitelist_patterns'] = [&#10    'system.menu.*',&#10  ];&#10}&#10