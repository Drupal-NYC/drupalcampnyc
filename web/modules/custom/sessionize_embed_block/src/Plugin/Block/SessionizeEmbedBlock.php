<?php

namespace Drupal\sessionize_embed_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
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
   * Protected member variable.
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
    // @todo: Fall back on global configuration.
    // Local configuration (per-block).
    $config = $this->getConfiguration();
    // Global configuration. (This does not work at the moment.)
    // $globalEmbedId = $this->sessionizeEmbed->getGlobalEmbedId();
    // $globalEmbedStyle = $this->sessionizeEmbed->getGlobalEmbedStyle();
    $embed_id = $config['embed_id'] ?? '6mh71zh8';
    $embed_style = $config['embed_style'] ?? 'GridSmart';
    return [
      'label_display' => FALSE,
      'embed_id' => $embed_id,
      'embed_style' => $embed_style,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();
    $embed_id = $config['embed_id'];
    $embed_style = $config['embed_style'];

    $form['form_config'] = [
      '#theme_wrappers' => ['container'],
    ];
    $form['form_config']['embed_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Embed ID'),
      '#required' => TRUE,
      '#default_value' => $embed_id,
      '#description' => $this->t('Sessionize Embed ID.'),
    ];
    $form['form_config']['embed_style'] = [
      '#type' => 'select',
      '#title' => $this->t('Embed Style'),
      '#required' => TRUE,
      '#default_value' => $embed_style,
      '#options' => [
        'GridSmart' => $this->t('GridSmart'),
        'Sessions' => $this->t('Sessions'),
        'Speakers' => $this->t('Speakers'),
        'SpeakerWall' => $this->t('SpeakerWall (retired)'),
        'GridTable' => $this->t('GridTable (retired)'),
        'Grid' => $this->t('Grid'),
      ],
      '#empty_option' => $this->t('-- Select --'),
      '#description' => $this->t('Sessionize Embed style.'),
    ];

    // Computed Embed Code configuration (read-only).
    $form['form_config']['sessionize_embed_block_computed_base_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Computed base URL (Preview)'),
      '#default_value' => $this->sessionizeEmbed->getSessionizeUrl($embed_id, $embed_style),
      '#description' => $this->t('Read-only value based on config. Save changes to update.'),
      '#attributes' => ['disabled' => 'disabled'],
    ];
    $form['form_config']['sessionize_embed_block_computed_embed_code'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Computed Embed Code (Preview)'),
      '#default_value' => $this->sessionizeEmbed->getSessionizeEmbed($embed_id, $embed_style),
      '#description' => $this->t('Read-only value based on config. Save changes to update.'),
      '#attributes' => ['disabled' => 'disabled'],
      '#size' => 120,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    parent::blockSubmit($form, $form_state);
    $values = $form_state->getValues();
    // dump($values) && die;.
    $this->configuration['label_display'] = $values['label_display'];
    $this->configuration['embed_id'] = $values['form_config']['embed_id'];
    $this->configuration['embed_style'] = $values['form_config']['embed_style'];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();
    $embed_id = $config['embed_id'] ?? '6mh71zh8';
    $embed_style = $config['embed_style'] ?? 'GridSmart';
    $renderable = [
      '#theme' => 'sessionize_embed_block__embed',
      '#embed_url' => $this->sessionizeEmbed->getSessionizeUrl($embed_id, $embed_style),
    ];

    return $renderable;
  }

}
