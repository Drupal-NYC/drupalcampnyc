<?php

namespace Drupal\de_core;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\UserAccessControlHandler;

class CustomUserAccessControlHandler extends UserAccessControlHandler {
    protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account)
    {
        // We don't treat the user label as privileged information, so this check
        // has to be the first one in order to allow labels for all users to be
        // viewed, including the special anonymous user.
        if ($operation === 'view label') {
            return parent::checkAccess($entity, $operation, $account);
        }

        // The anonymous user's profile can neither be viewed, updated nor deleted.
        if ($entity->isAnonymous()) {
            return parent::checkAccess($entity, $operation, $account);
        }

        // Administrators can view/update/delete all user profiles.
        if ($account->hasPermission('administer users')) {
            return parent::checkAccess($entity, $operation, $account);
        }

        if ($operation == 'view') {
            if ($account->id() !== $entity->id()) {
                // Blocking all users that do now want to be shown in a public list.
                $public_listing = $entity->get('field_u_pub_attendee_list')->getValue();
                if ($public_listing[0]['value'] == '0') {
                    return AccessResult::forbidden();
                }
            }
            return parent::checkAccess($entity, $operation, $account);
        }

        return parent::checkAccess($entity, $operation, $account);
    }
}