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
   * Get Global Embed ID.
   *
   * @return string
   *   The Gllobal Embed ID.
   */
  public function getGlobalEmbedId() {
    $config = $this->configFactory->get(static::SETTINGS);
    return $config->get('embed_id');
  }

  /**
   * Get Global Embed Style.
   *
   * @return string
   *   The Gllobal Embed Style.
   */
  public function getGlobalEmbedStyle() {
    $config = $this->configFactory->get(static::SETTINGS);
    return $config->get('embed_style');
  }

  /**
   * Generate Sessionize embed URL based on config settings.
   *
   * @param string $embed_id
   *   The Sessionize embed ID.
   * @param string $embed_style
   *   The Sessionize embed style.
   *
   * @return string
   *   The Sessionize embed URL used in Sessionize embed code.
   */
  public function getSessionizeUrl($embed_id, $embed_style) {
    $sessionize_url = 'https://sessionize.com/api/v2/' . $embed_id . '/view/' . $embed_style;
    // $sessionize_url = 'https://sessionize.com/api/v2/' . $embed_id . '/view/GridSmart';
    return $sessionize_url;
  }

  /**
   * Preview Sessionize embed code using generated URL above.
   *
   * @param string $embed_id
   *   The Sessionize embed ID.
   * @param string $embed_style
   *   The Sessionize embed style.
   *
   * @return string
   *   The Sessionize embed code markup used in Sessionize embed Block.
   */
  public function getSessionizeEmbed($embed_id, $embed_style) {
    $sessionize_url = $this->getSessionizeUrl($embed_id, $embed_style);
    $sessionize_embed = '<script type="text/javascript" src="' . $sessionize_url . '"></script>';
    return $sessionize_embed;
  }

}
