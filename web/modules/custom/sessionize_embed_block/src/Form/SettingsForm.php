<?php

namespace Drupal\sessionize_embed_block\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\sessionize_embed_block\Sessionize\Embed;

/**
 * Provides a form to configure CareAdviser CTA Base module settings.
 */
class SettingsForm extends ConfigFormBase implements ContainerInjectionInterface {

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
   */
  public function __construct(ConfigFactoryInterface $configFactory, Embed $sessionizeEmbed) {
    $this->configFactory = $configFactory;
    $this->sessionizeEmbed = $sessionizeEmbed;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('sessionize.embed')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'sessionize_embed_block_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    $form['form_config'] = [
      '#theme_wrappers' => ['container'],
    ];
    $form['form_config']['sessionize_embed_block_embed_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Embed ID'),
      '#required' => TRUE,
      '#default_value' => $config->get('embed_id') ?? [],
      '#description' => $this->t('Sessionize Embed ID.'),
    ];
    $form['form_config']['sessionize_embed_block_embed_style'] = [
      '#type' => 'select',
      '#title' => $this->t('Embed Style'),
      '#required' => TRUE,
      '#default_value' => $config->get('embed_style') ?? [],
      '#options' => [
        'GridSmart' => $this->t('GridSmart'),
        'Sessions' => $this->t('Sessions'),
        'Speakers' => $this->t('Speakers'),
        'SpeakerWall' => $this->t('SpeakerWall'),
        'GridTable' => $this->t('GridTable'),
        'Grid' => $this->t('Grid'),
      ],
      '#empty_option' => $this->t('-- Select --'),
      '#description' => $this->t('Sessionize Embed style.'),
    ];

    // Computed Embed Code configuration (read-only).
    $form['form_config']['sessionize_embed_block_computed_base_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Computed base URL (Preview)'),
      '#default_value' => $this->sessionizeEmbed->getSessionizeUrl(),
      '#description' => $this->t('Read-only value based on config. Save changes to update.'),
      '#attributes' => ['disabled' => 'disabled'],
    ];
    $form['form_config']['sessionize_embed_block_computed_embed_code'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Computed Embed Code (Preview)'),
      '#default_value' => $this->sessionizeEmbed->getSessionizeEmbed(),
      '#description' => $this->t('Read-only value based on config. Save changes to update.'),
      '#attributes' => ['disabled' => 'disabled'],
      '#size' => 120,
    ];

    $form['form_preview'] = [
      '#theme_wrappers' => ['container'],
    ];
    $form['form_preview']['preview_embed'] = [
      '#markup' => $this->renderEmbed(),
      '#theme_wrappers' => ['container'],
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $embed_id = $form_state->getValue('sessionize_embed_block_embed_id');
    $embed_style = $form_state->getValue('sessionize_embed_block_embed_style');
    $this->messenger()->addMessage($this->t('Embed Style: %embed_style', [
      '%embed_style' => $embed_style,
    ]));
    $this->messenger()->addMessage($this->t('Embed Style: %embed_style', [
      '%embed_style' => $embed_style,
    ]));
    // Retrieve the configuration.
    $this->config(static::SETTINGS)
    // Set the submitted configuration settings.
      ->set('embed_id', $embed_id)
      ->set('embed_style', $embed_style)
      ->save();
    parent::submitForm($form, $form_state);
  }

  /**
   * Theme function to render Sessionize embed.
   */
  protected function renderEmbed() {
    $build['#theme'] = 'sessionize_embed_block__embed';

    $sessionize_embed = render($build);
    return $sessionize_embed;
  }

}
