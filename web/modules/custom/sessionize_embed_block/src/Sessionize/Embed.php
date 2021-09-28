<?php

namespace Drupal\sessionize_embed_block\Sessionize;

/**
 * @file
 * Contains \Drupal\sessionize_embed_block\Sessionize\Embed.
 */

use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Provides Sessionize Embed code generation methods.
 */
class Embed {

  /**
   * Protected member variable.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'sessionize_embed_block.settings';

  /**
   * Constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The configFactory interface.
   */
  public function __construct(ConfigFactoryInterface $configFactory) {
    $this->configFactory = $configFactory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
    );
  }

  /**
   * Generate Sessionize Embed URL based on config settings.
   *
   * @return string
   *   The Sessionize Embed URL used in Sessionize Embed code.
   */
  public function getSessionizeUrl() {
    $config = $this->configFactory->get(static::SETTINGS);
    $embed_id = $config->get('embed_id') ?? 'Error';
    $embed_style = $config->get('embed_style') ?? 'Error';
    $sessionize_url = 'https://sessionize.com/api/v2/' . $embed_id . '/view/' . $embed_style;
    // $sessionize_url = 'https://sessionize.com/api/v2/' . $embed_id . '/view/GridSmart';
    return $sessionize_url;
  }

  /**
   * Preview Sessionize Embed code using generated URL above.
   *
   * @return string
   *   The Sessionize Embed code markup used in Sessionize Embed Block.
   */
  public function getSessionizeEmbed() {
    $sessionize_url = $this->getSessionizeUrl();
    $sessionize_embed = '<script type="text/javascript" src="' . $sessionize_url . '"></script>';
    return $sessionize_embed;
  }

}
