<?php

namespace Drupal\de_core\EventSubscriber;

use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class InfoScreenHeadersSubscriber implements EventSubscriberInterface {

  public function InfoScreenResponse(ResponseEvent $event) {

    // Act on infoscreen paths.
    $request = $event->getRequest();
    $path = $request->getPathInfo();
    if (strpos($path, '/infoscreen/') === 0) {

      // Allow this page to be embedded in an iframe.
      $response = $event->getResponse();
      $response->headers->remove('X-Frame-Options');

      // Set not cacheable based on FinishResponseSubscriber::setResponseNotCacheable.
      $response->headers->set('Cache-Control', 'no-cache, must-revalidate');
      $response->setExpires(\DateTime::createFromFormat('j-M-Y H:i:s T', '19-Nov-1978 05:00:00 UTC'));
      $response->setEtag(NULL);
      $response->setLastModified(NULL);
      $response->setVary(NULL);
    }
  }

  public static function getSubscribedEvents() {
    $events[KernelEvents::RESPONSE][] = array('InfoScreenResponse', -10);
    return $events;
  }
}
