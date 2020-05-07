<?php

namespace Drupal\de_core_actions\Plugin\Action;

use Drupal\Core\Action\ActionBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Blocks a user.
 *
 * @Action(
 *   id = "mark_user_as_speaker",
 *   label = @Translation("Mark user as Speaker"),
 *   type = "user"
 * )
 */
class MarkAsSpeaker extends ActionBase {

  /**
   * {@inheritdoc}
   */
  public function execute($account = NULL) {
    $account->original = clone $account;
    $account->field_speaker[0]->value = 'yes';
    $account->save();
  }

  /**
   * {@inheritdoc}
   */
  public function access($object, AccountInterface $account = NULL, $return_as_object = FALSE) {
    /** @var \Drupal\user\UserInterface $object */
    $access = $object->status->access('edit', $account, TRUE)
      ->andIf($object->access('update', $account, TRUE));

    return $return_as_object ? $access : $access->isAllowed();
  }

}
