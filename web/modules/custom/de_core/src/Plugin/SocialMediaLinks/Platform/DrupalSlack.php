<?php

namespace Drupal\de_core\Plugin\SocialMediaLinks\Platform;

use Drupal\social_media_links\PlatformBase;

/**
 * Provides 'slack' platform.
 *
 * @Platform(
 *   id = "drupal_slack",
 *   name = @Translation("DrupalNYC Slack"),
 *   urlPrefix = "https://www.drupalnyc.org/",
 *   iconName = "slack",
 * )
 */
class DrupalSlack extends PlatformBase {}
