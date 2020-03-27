<?php

namespace Drupal\de_core\Command;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\Entity\Node;
use Drupal\user\Entity\User;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Drupal\Console\Core\Command\ContainerAwareCommand;
use Drupal\Console\Annotations\DrupalCommand;
use Drupal\Console\Utils\DrupalApi;
/**
 * Class UpdateSpeakersCommand.
 *
 * @DrupalCommand (
 *     extension="de_core",
 *     extensionType="module"
 * )
 */
class UpdateSpeakersCommand extends ContainerAwareCommand
{
  /**
   * @var DrupalApi
   */
  protected $drupalApi;

  /**
   * @var EntityTypeManagerInterface
   */
  protected $entity_type_manager;

  /**
   * RoleCommand constructor.
   *
   * @param DrupalApi $drupalApi
   */
  public function __construct(DrupalApi $drupalApi, EntityTypeManagerInterface $entityTypeManager)
  {
    $this->drupalApi = $drupalApi;
    $this->entity_type_manager = $entityTypeManager;
    parent::__construct();
  }

  /**
   * {@inheritdoc}
   */
  protected function configure() {
    $this
      ->setName('de_core:update_speakers')
      ->setDescription($this->trans('commands.de_core.update_speakers.description'))
      ->setAliases(['de_speakers']);
  }

  /**
   * {@inheritdoc}
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $this->getIo()->info('executing');
    $uids = [];
    $node_storage = $this->entity_type_manager->getStorage('node');
    $node_query = $node_storage->getQuery();
    $nids = $node_query->condition('status', Node::PUBLISHED)
      ->condition('type', 'session')
      ->execute();

    /** @var Node[] $nodes */
    $nodes = $node_storage->loadMultiple($nids);
    $nodes = array_filter($nodes, function($node) {
      $moderation_states = $node->get('moderation_state')->getValue();
      return ($moderation_states[0]['value'] === 'accepted');
    });

    foreach ($nodes as $node) {
      foreach ($node->get('field_speakers')->getValue() as $speaker) {
        $uids[$speaker['target_id']] = $speaker['target_id'];
      }
      $uids[$node->getOwnerId()] = $node->getOwnerId();
    }

    /** @var User[] $users */
    $users = $this->entity_type_manager->getStorage('user')->loadMultiple($uids);
    $users = array_filter($users, function($user) {
      return !$user->hasRole('speaker');
    });
    foreach ($users as $user) {
      $this->getIo()->successLite($user->getAccountName() . ' got the speaker role');
      $user->addRole('speaker');
      $user->save();
    }
    $this->getIo()->info(count($users) . ' got the speaker role.');
    $this->getIo()->success($this->trans('commands.de_core.update_speakers.messages.success'));
  }
}
