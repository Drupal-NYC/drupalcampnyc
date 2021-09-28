<?php

namespace Drupal\sessionize_embed_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\sessionize_embed_block\Sessionize\Embed;

/**
 * Provides a 'Sessionize Embed' block.
 *
 * @Block(
 *   id = "sessionize_embed",
 *   admin_label = @Translation("Sessionize Embed")
 * )
 */
class SessionizeEmbedBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Protected member varioable.
   *
   * @var \Drupal\sessionize_embed_block\Sessionize\Embed
   *   The Sessionize Embed service.
   */
  protected $sessionizeEmbed;

  /**
   * Constructs a new SessionizeEmbedBlock.
   *
   * @param array $configuration
   *   The configuration.
   * @param string $plugin_id
   *   The plugin ID.
   * @param mixed $plugin_definition
   *   The plugin definition.
   * @param \Drupal\sessionize_embed_block\Sessionize\Embed $sessionizeEmbed
   *   The Sessionize Embed service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, Embed $sessionizeEmbed) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->sessionizeEmbed = $sessionizeEmbed;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('sessionize.embed')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['label_display' => FALSE];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $renderable = [
      '#theme' => 'sessionize_embed_block__embed',
      '#embed_url' => $this->sessionizeEmbed->getSessionizeUrl(),
    ];

    return $renderable;
  }

}
