<?php

namespace Drupal\dcync_reg_links\Plugin\Block;

use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Provides a 'RegLinksBlock' block.
 *
 * @Block(
 *  id = "reg_links_block",
 *  admin_label = @Translation("Registration Links"),
 * )
 */
class RegLinksBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['registration_link'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Registration Link'),
      '#description' => $this->t('Provide the full URL to the registration page.'),
      '#default_value' => isset($this->configuration['registration_link']) ? $this->configuration['registration_link'] : 'https://www.eventbrite.com/e/drupalcampnyc2016-registration-19937683147',
      '#maxlength' => 128,
      '#size' => 128,
      '#weight' => '1',
    ];
    $form['registration_link_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Registration Link Text'),
      '#description' => $this->t('The text to display as the registration link.'),
      '#default_value' => isset($this->configuration['registration_link_text']) ? $this->configuration['registration_link_text'] : 'Register Now!',
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '1',
    ];
    $form['sponsorship_link'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Sponsorship Link'),
      '#description' => $this->t('The full URL to the sponsorship page.'),
      '#default_value' => isset($this->configuration['sponsorship_link']) ? $this->configuration['sponsorship_link'] : 'https://www.eventbrite.com/e/drupalcampnyc2016-registration-19937683147',
      '#maxlength' => 128,
      '#size' => 128,
      '#weight' => '2',
    ];
    $form['sponsorship_link_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Sponsorship Link Text'),
      '#description' => $this->t('The text to display as the sponsorship link.'),
      '#default_value' => isset($this->configuration['sponsorship_link_text']) ? $this->configuration['sponsorship_link_text'] : 'Sponsor DCNYC16 Now!',
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '2',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockValidate($form, FormStateInterface $form_state) {
    // Instantiate UrlHelper object to validate the URL's.
    $url_helper = new UrlHelper();
    // Build an array of the links that need validating. If more fields are
    // added later, add another entry to the links array.
    $links = [];
    $links['registration_link'] = $form_state->getValue('registration_link');
    $links['sponsorship_link'] = $form_state->getValue('sponsorship_link');
    // Validate and set errors where appropriate.
    foreach ($links as $key => $link) {
      if ($link == '') {
        break;
      }
      $validity = $url_helper->isValid($link, TRUE);
      if ($validity != TRUE) {
        $form_state->setErrorByName($key, "The value must be a full URL similar to http://www.example.com.");
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['registration_link'] = $form_state->getValue('registration_link');
    $this->configuration['registration_link_text'] = $form_state->getValue('registration_link_text');
    $this->configuration['sponsorship_link'] = $form_state->getValue('sponsorship_link');
    $this->configuration['sponsorship_link_text'] = $form_state->getValue('sponsorship_link_text');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    $registration_url = Url::fromUri($this->configuration['registration_link']);
    $sponsorship_url = Url::fromUri($this->configuration['sponsorship_link']);
    $button_attributes = [
      'class' => [
        'button',
        'black',
        'button-primary',
      ],
    ];
    $build['dcnyc_registration_links'] = [
      '#theme' => 'dcnyc_registration_links',
      '#registration_page' => [
        '#type' => 'link',
        '#title' => $this->configuration['registration_link_text'],
        '#options' => $registration_url->getOptions(),
        '#attributes' => $button_attributes,
        '#url' => $registration_url,
      ],
      '#sponsorship_page' => [
        '#type' => 'link',
        '#title' => $this->configuration['sponsorship_link_text'],
        '#options' => $sponsorship_url->getOptions(),
        '#attributes' => $button_attributes,
        '#url' => $sponsorship_url,
      ],
    ];

    return $build;
  }

}
