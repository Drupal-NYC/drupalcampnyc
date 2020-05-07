<?php

namespace Drupal\de_core\Plugin\Field\FieldFormatter;

use Drupal\Core\Annotation\Translation;
use Drupal\Core\Field\Annotation\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use GuzzleHttp\Exception\RequestException;

/**
 * Class LinkEmbedFormatter
 * @package Drupal\de_core\Plugin\Field\FieldFormatter
 * @FieldFormatter(
 *     id = "linkembed",
 *     label = @Translation("oEmbed Link"),
 *     field_types={
 *        "link"
 *     },
 * )
 */
class LinkEmbedFormatter extends FormatterBase {

  private $maxWidth = 300;

  private $providers = "#https?://(www\.)?youtube.com/watch.*#i | http://www.youtube.com/oembed | true
#https?://youtu\.be/.*#i | http://www.youtube.com/oembed | true
#https?://(www\.)?vimeo\.com/.*#i | http://vimeo.com/api/oembed.json | true
#http://(www\.)?hulu\.com/watch/.*#i | http://www.hulu.com/api/oembed.json | true
#https?://(www\.)?twitter.com/.+?/status(es)?/.*#i | https://api.twitter.com/1/statuses/oembed.json | true
#https?://(www\.)?instagram.com/p/.*#i | https://api.instagram.com/oembed | true";

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t('Displays the random string.');
    return $summary;
  }


  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'oembed_maxwidth' => 500,
      'oembed_providers' => "#https?://(www\.)?youtube.com/watch.*#i | http://www.youtube.com/oembed | true
#https?://youtu\.be/.*#i | http://www.youtube.com/oembed | true 
#https?://(www\.)?vimeo\.com/.*#i | http://vimeo.com/api/oembed.json | true
#http://(www\.)?hulu\.com/watch/.*#i | http://www.hulu.com/api/oembed.json | true 
#https?://(www\.)?twitter.com/.+?/status(es)?/.*#i | https://api.twitter.com/1/statuses/oembed.json | true 
#https?://(www\.)?instagram.com/p/.*#i | https://api.instagram.com/oembed | true",
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];

//    $this->settings = self::defaultSettings();
    foreach ($items as $delta => $item) {
      // Render each element as markup.
      $element[$delta] = [
        '#type' => 'inline_template',
        '#template' => $this->itemEmbed($item->getValue())];
    }

    return $element;
  }

  /**
   * @param $url
   * @return string
   */
  private function itemEmbed($values) {

    static $providers = [];

    if (empty($providers)) {
      $providers_string = $this->providers;
      $providers_line = explode("\n", $providers_string);
      foreach ($providers_line as $value) {
        $items = explode(" | ", $value);
        $key = array_shift($items);
        $providers[$key] = $items;
      }
    }

    $url = $values['uri'];

    foreach ($providers as $matchmask => $data) {
      list($providerurl, $regex) = $data;

      $regex = preg_replace('/\s+/', '', $regex);

      if ($regex == 'false') {
        $regex = false;
      }

      if (!$regex) {
        $matchmask = '#' . str_replace( '___wildcard___', '(.+)', preg_quote(str_replace('*', '___wildcard___', $matchmask), '#')) . '#i';
      }
      if (preg_match($matchmask, $url)) {
        $provider = $providerurl;
        break;
      }
    }

    if ($regex === 'LOCAL') {
      $output = $this->getContents($provider, $url);
    }
    elseif (!empty($provider)) {
      $client = \Drupal::httpClient();
      $response = '';

      try {
        $request = $client->get($provider . '?url=' . $url . '&format=json&maxwidth=' . $this->maxWidth . '&omit_script=true');
        $response = $request->getBody();
      }

      catch (RequestException $e) {
        watchdog_exception('link_oembed', $e);
      }

      if (!empty($response)) {
        $embed = json_decode($response);
        if (!empty($embed->html)) {
          $output = $embed->html;
        }
        elseif ($embed->type == 'photo') {
          $output = '<img src="' . $embed->url . '" title="' . $embed->title . '" style="width: 100%" />';
          $output = '<a href="' . $url . '">' . $output .'</a>';
        }
      }
    }

    $output = empty($output) ? $url : $output;

    return $output;
  }

  /**
   * Locally create HTML after pattern study for sites that don't support oEmbed.
   */
  private function getContents($provider, $url) {
    $width = $this->maxWidth;

    switch ($provider) {
      case 'google-maps':
        //$url    = str_replace('&', '&amp;', $url); Though Google encodes ampersand, it seems to work without it.
        $height = (int)($width / 1.3);
        $embed  = "<iframe width='{$width}' height='{$height}' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='{$url}&output=embed'></iframe><br /><small><a href='{$url}&source=embed' style='color:#0000FF;text-align:left'>View Larger Map</a></small>";
        break;
      case 'google-docs':
        $height = (int)($width * 1.5);
        $embed  = "<iframe width='{$width}' height='{$height}' frameborder='0' src='{$url}&widget=true'></iframe>";
        break;
      default:
        $embed = $url;
    }

    return $embed;
  }
}
