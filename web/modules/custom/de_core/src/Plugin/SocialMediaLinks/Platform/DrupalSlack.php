<?php

namespace Drupal\de_core\Plugin\SocialMediaLinks\Platform;

use Drupal\social_media_links\PlatformBase;

/**
 * Provides 'medium' platform.
 *
 * @Platform(
 *   id = "drupal_slack",
 *   name = @Translation("Drupal Slack"),
 *   urlPrefix = "https://drupal.slack.com/",
 *   iconName = "slack",
 * )
 */
class DrupalSlack extends PlatformBase {}
