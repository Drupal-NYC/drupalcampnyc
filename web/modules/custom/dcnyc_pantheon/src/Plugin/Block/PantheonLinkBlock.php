<?php

namespace Drupal\dcnyc_pantheon\Plugin\Block;

use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'PantheonLinkBlock' block.
 *
 * @Block(
 *  id = "pantheon_link_block",
 *  admin_label = @Translation("Pantheon link block"),
 * )
 */
class PantheonLinkBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['pantheon_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Pantheon URL'),
      '#description' => $this->t('Pantheon URL to link the image'),
      '#default_value' => isset($this->configuration['pantheon_url']) ? $this->configuration['pantheon_url'] : 'https://pantheon.io',
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
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
    $links['pantheon_url'] = $form_state->getValue('pantheon_url');
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
    $this->configuration['pantheon_url'] = $form_state->getValue('pantheon_url');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    global $base_root;
    $build = [];
    $build['dcnyc_pantheon_footer'] = [
      '#theme' => 'dcnyc_pantheon_footer',
      '#pantheon_url' => $this->configuration['pantheon_url'],
      '#pantheon_image' => $base_root . '/modules/custom/dcnyc_pantheon' . '/poweredBYPantheon.png',
    ];
    return $build;
  }

}
