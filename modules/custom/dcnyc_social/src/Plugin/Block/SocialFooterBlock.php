<?php

/**
 * @file
 * Contains \Drupal\dcnyc_social\Plugin\Block\SocialFooterBlock.
 */

namespace Drupal\dcnyc_social\Plugin\Block;

use Drupal\Component\Utility\UrlHelper;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use \Drupal\Core\Url;


/**
 * Provides a 'SocialFooterBlock' block.
 *
 * @Block(
 *  id = "social_footer_block",
 *  admin_label = @Translation("Connect Links"),
 * )
 */
class SocialFooterBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['facebook_url'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Facebook URL'),
      '#description' => $this->t('Provide the full URL for the Facebook page.'),
      '#default_value' => isset($this->configuration['facebook_url']) ? $this->configuration['facebook_url'] : 'https://www.facebook.com/Drupalcampnyc',
      '#maxlength' => 128,
      '#size' => 128,
      '#weight' => '1',
    );
    $form['twitter_url'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Twitter URL'),
      '#description' => $this->t('Provide the full URL for the Twitter profile.'),
      '#default_value' => isset($this->configuration['twitter_url']) ? $this->configuration['twitter_url'] : 'https://twitter.com/drupalnyc',
      '#maxlength' => 128,
      '#size' => 128,
      '#weight' => '2',
    );
    $form['gdo_url'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('G.D.O. URL'),
      '#description' => $this->t('Provide the full URL for the groups.drupal.org page.'),
      '#default_value' => isset($this->configuration['gdo_url']) ? $this->configuration['gdo_url'] : 'https://groups.drupal.org/nyc',
      '#maxlength' => 128,
      '#size' => 128,
      '#weight' => '3',
    );

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
    $links['facebook_url'] = $form_state->getValue('facebook_url');
    $links['twitter_url'] = $form_state->getValue('twitter_url');
    $links['gdo_url'] = $form_state->getValue('gdo_url');
    // Create an error variable to prevent setting the error message repeatedly.
    $error_set = FALSE;
    // Validate and set errors where appropriate.
    foreach ($links as $key => $link) {
      if ($link == '') {
        break;
      }
      $validity = $url_helper->isValid($link, TRUE);
      if ($validity != TRUE) {
        $form_state->setErrorByName($key, "The value must be a full URL similar to http://www.example.com.");
        // Using drupal_set_message because of a bug with setError that is
        // causing the form to not submit correctly, but isn't displaying
        // messages.
        if ($error_set == FALSE) {
          drupal_set_message('All values must be full URLs of format: http://www.example.com.', 'error');
          // Prevent the error from outputting multiple times.
          $error_set = TRUE;
        }
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['facebook_url'] = $form_state->getValue('facebook_url');
    $this->configuration['twitter_url'] = $form_state->getValue('twitter_url');
    $this->configuration['gdo_url'] = $form_state->getValue('gdo_url');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = array();

    $facebook_url = Url::fromUri($this->configuration['facebook_url']);
    $twitter_url = Url::fromUri($this->configuration['twitter_url']);
    $gdo_url = Url::fromUri($this->configuration['gdo_url']);
    $build['social_footer_block_facebook_url'] = array(
      '#theme' => 'dcnyc_social_links',
      '#facebook_page' => array(
        '#type' => 'link',
        '#title' => 'Facebook',
        '#options' => $facebook_url->getOptions(),
        '#url' => $facebook_url,
      ),
      '#twitter_page' => array(
        '#type' => 'link',
        '#title' => 'Twitter',
        '#options' => $twitter_url->getOptions(),
        '#url' => $twitter_url,
      ),
      '#gdo_page' => array(
        '#type' => 'link',
        '#title' => 'Drupal Groups',
        '#options' => $gdo_url->getOptions(),
        '#url' => $gdo_url,
      ),
    );

    return $build;
  }

}
