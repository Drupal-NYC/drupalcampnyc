<?php

use DrupalFinder\DrupalFinder;
use Robo\Contract\VerbosityThresholdInterface;
use Robo\Tasks;
use Robo\Result;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Finder\Finder;

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends Tasks {

  /**
   * Drupal root path.
   *
   * @var string
   */
  protected $drupalRoot;

  /**
   * Project root path.
   *
   * @var string
   */
  protected $projectRoot;

  /**
   * Builds separate artifact and pushes to remote defined in $DEPLOY_TARGET.
   *
   * If the tag parameter is set, deploy:tag is called, otherwise deploy:branch.
   *
   * @param array $options
   *   Options from the command line.
   *
   * @aliases deploy
   *
   * @throws \Exception
   *   Throws an exception if the deployment fails.
   */
  public function deployBuild(array $options = [
    'branch' => NULL,
    'tag' => NULL,
    'commit-msg' => NULL,
    'remote-branch' => NULL,
    'remote' => NULL,
    'build_id' => NULL,
    'date-tag' => FALSE,
  ]) {
    $result = $this->deployBranch($options);
    if ($result instanceof Result && $result->wasSuccessful()) {
      $this->io()
        ->success('Deployment succeeded.');
    }
    else {
      throw new \Exception('Deployment failed.');
    }
  }

  /**
   * Builds separate artifact and pushes to remote as a branch.
   *
   * @param array $options
   *   Options from the command line or internal call.
   *
   * @return \Robo\Result
   *   The result of the final push.
   */
  public function deployBranch(array $options = [
    'branch' => InputOption::VALUE_REQUIRED,
    'commit-msg' => InputOption::VALUE_REQUIRED,
    'remote-branch' => NULL,
    'remote' => NULL,
    'build_id' => NULL,
  ]) {
    $this->setDeploymentOptions($options);
    $this->say('Deploying to branch ' . $options['branch']);
    $this->setDeploymentVersionControl($options);
    $this->getSanitizedBuild();
    $this->setDeploymentCommit($options);
    $this->setCleanMerge($options);
    //return $this->getPushResult($options);
  }

  /**
   * Insures that appropriate options are present.
   *
   * @param array $options
   *   Options passed from the command.
   */
  protected function setDeploymentOptions(array &$options) {
    $options['remote'] = $options['remote'] ?? getenv('DEPLOY_TARGET');
    $options['branch'] = $options['branch'] ?? getenv('CI_BRANCH');
    $options['remote-branch'] = $options['remote-branch'] ?? $options['branch'];
    $options['deploy-branch'] = $options['remote-branch'] . '-deploy';
    $options['build_id'] = $options['build_id'] ?? substr(getenv('CI_COMMIT_ID'), 0, 7);
    // A target is required.
    if (empty($options['remote'])) {
      // We need a repository target.
      throw new \UnexpectedValueException('Environment variable $DEPLOY_TARGET must be set before deployment or the --remote argument passed.');
    }
    // As is a branch.
    if (empty($options['branch'])) {
      throw new \UnexpectedValueException('A branch must be specified.');
    }
    // There should also be a commit-message.
    if (empty($options['commit-msg'])) {
      $options['commit-msg'] = 'Deployment built for Pantheon on' . date(DATE_RFC2822);
      if (!empty($options['build_id'])) {
        $options['commit-msg'] .= ' Build ID: ' . $options['build_id'];
      }
    }
    $remote_name = $this->config->get('site_alias_name');
    // Store for later use.
    $options['remote_name'] = $remote_name;
  }

  /**
   * Adds the deployment target as a remote.
   *
   * @param array $options
   *   Options passed from the command.
   *
   * @throws \Exception
   *   Throws an exception if the git tasks fail so that deployment will abort.
   */
  protected function setDeploymentVersionControl(array $options) {
    $remote_url = $options['remote'];
    $remote_name = $options['remote_name'];
    $this->say("Will push to git remote $remote_name at $remote_url");
    // Collect all the needed tasks and run them.
    $collection = $this->collectionBuilder();
    $collection->addTask(
      $this->taskExec("git remote add $remote_name $remote_url")
        ->dir($this->getProjectRoot())
        ->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
    );
    $shallowCheck = $this->taskExec('git rev-parse --is-shallow-repository --no-revs HEAD')
      ->interactive(FALSE)
      ->run();
    if (trim($shallowCheck->getMessage()) == 'true') {
      $collection->addTask(
        $this->taskExec('git fetch --unshallow')
      );
    }
    $result = $collection->run();
    if ($result instanceof Result && !$result->wasSuccessful()) {
      throw new \Exception('Git configuration failed.');
    }
  }

  /**
   * Removes files and directories that should not be deployed.
   *
   * Also replaces .gitignore with deployment specific versions.
   *
   * @throws \Exception
   *   Throws an exception if the files are unable to be modified.
   */
  protected function getSanitizedBuild() {
    $this->say('Sanitizing artifact...');
    $this->say('Finding .git subdirectories...');
    $git = new Finder();
    $git
      ->in([
        $this->getProjectRoot() . '/vendor',
        $this->getProjectRoot() . '/web',
      ])
      ->directories()
      ->ignoreDotFiles(FALSE)
      ->ignoreVCS(FALSE)
      ->name('/^\.git$/');
    $this->say($git->count() . ' .git directories found');

    $this->say('Finding any CHANGELOG.txt');
    $changelog = new Finder();
    $changelog
      ->in($this->config->getProjectRoot())
      ->files()
      ->name('CHANGELOG.txt');
    $this->say($changelog->count() . ' CHANGELOG.txt files found');

    $this->say('Finding .gitignore in themes');
    $theme_ignores = new Finder();
    $theme_ignores
      ->in([$this->getDrupalRoot() . '/themes'])
      ->ignoreDotFiles(FALSE)
      ->depth('< 2')
      ->files()
      ->name('/\.gitignore$/');
    $this->say($theme_ignores->count() . ' .gitignore files found in themes');

    $files = $git
      ->append($changelog)
      ->append($theme_ignores);

    $taskFilesystemStack = $this->taskFilesystemStack();
    foreach ($files->getIterator() as $item) {
      $taskFilesystemStack
        ->remove($item->getRealPath());
    }
    $collection = $this->collectionBuilder();
    $collection->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG);
    $taskFilesystemStack->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG);
    $collection->addTask($taskFilesystemStack);
    $collection->addTask(
      $this->taskFilesystemStack()
        ->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
        ->copy($this->getProjectRoot() . '/setup/deploy-gitignore',
          $this->getProjectRoot() . '/.gitignore', TRUE)
    );
    $result = $collection->run();
    if ($result instanceof Result && !$result->wasSuccessful()) {
      throw new \Exception('Unable to sanizize the build.');
    }
  }

  /**
   * Commits the result of the deployment build.
   *
   * @param array $options
   *   Options passed from the command.
   *
   * @throws \Exception
   *   Throws an exception if the git tasks fail so that deployment will abort.
   */
  protected function setDeploymentCommit(array $options) {
    $gitJobs = $this->taskGitStack()
      ->stopOnFail()
      ->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
      ->checkout($options['branch'])
      ->add('-A')
      ->commit($options['commit-msg']);
    $result = $gitJobs->run();
    if ($result instanceof Result && !$result->wasSuccessful()) {
      throw new \Exception('Git commit failed.');
    }
  }

  /**
   * Cleanly merges the current branch into the remote branch of the same name.
   *
   * Uses a simulated "theirs" strategy to prefer any changes or updates in
   * the current branch over that in the remote.
   *
   * @param array $options
   *   Options passed from the command.
   *
   * @throws \Exception
   *   Throws an exception if the branch checkout or merge fails.
   *
   * @see https://stackoverflow.com/questions/173919/is-there-a-theirs-version-of-git-merge-s-ours/4969679#4969679
   */
  protected function setCleanMerge(array $options) {
    // We need some simple variables for expansion in a string.
    $remote = $options['remote_name'];
    $target = $remote . '/' . $options['remote-branch'];
    $message = 'Merge to remote: ' . $options['commit-msg'];
    $local = $options['deploy-branch'];
    $this->say('Move to a new branch that tracks the target repo.');
    $gitJobs = $this->taskGitStack()
      ->stopOnFail()
      ->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
      ->exec("fetch $remote")
      ->checkout("-b $local $target");
    $result = $gitJobs->run();
    if ($result instanceof Result && !$result->wasSuccessful()) {
      // The remote branch may not exist.  Just make the deploy branch.
      $gitJobs = $this->taskGitStack()
        ->stopOnFail()
        ->checkout("-b $local");
      $result = $gitJobs->run();
      if ($result instanceof Result && !$result->wasSuccessful()) {
        throw new \Exception('Unable to checkout or create a deployment branch.');
      }
    }
    // Now cleanly merge $options['branch'] into $options['deploy-branch']
    // with preference to $options['branch'] for any conflicts.
    $this->say('Merging changes into remote tracking branch');
    $merge = $this->taskGitStack()
      ->stopOnFail()
      ->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
      ->exec('merge -s ours ' . $options['branch'] . " -m \"$message\"")
      ->exec('branch branch-temp')
      ->exec('reset --hard ' . $options['branch'])
      ->exec('reset --soft branch-temp')
      ->exec('commit --amend -C HEAD')
      ->exec('branch -D branch-temp');
    if ($options['tag']) {
      $merge->tag($options['tag']);
    }
    $result = $merge->run();
    if ($result instanceof Result && !$result->wasSuccessful()) {
      throw new \Exception('Failed to merge deployment into the remote branch.');
    }
    $this->say('Code is ready to push');
  }

  /**
   * Attempts to push the build and returns the final result.
   *
   * @param array $options
   *   Options passed from the command.
   *
   * @return \Robo\Result
   *   The final task result.
   */
  protected function getPushResult(array $options) {
    $gitJobs = $this->taskGitStack()
      ->stopOnFail()
      ->setVerbosityThreshold(VerbosityThresholdInterface::VERBOSITY_DEBUG)
      ->push($options['remote_name'], $options['deploy-branch'] . ':' . $options['remote-branch']);
    if (!empty($options['tag'])) {
      $gitJobs->push($options['remote_name'], $options['tag']);
    }
    return $gitJobs->run();
  }

  /**
   * Utility function to insure root paths are set.
   */
  protected function setRoots() {
    // Values are set here so one empty is a suffient flag.
    if (empty($this->drupalRoot)) {
      $drupalFinder = new DrupalFinder();
      $drupalFinder->locateRoot(getcwd());
      $this->drupalRoot = $drupalFinder->getDrupalRoot();
      $this->projectRoot = $drupalFinder->getComposerRoot();
    }
  }

  /**
   * Get the path to the Drupal root directory.
   *
   * @return string
   *   The drupal root path.
   */
  public function getDrupalRoot() {
    if (empty($this->drupalRoot)) {
      $this->setRoots();
    }
    return $this->drupalRoot;
  }

  /**
   * Get the path to the project root directory.
   *
   * @return string
   *   The project root path.
   */
  public function getProjectRoot() {
    if (empty($this->projectRoot)) {
      $this->setRoots();
    }
    return $this->projectRoot;
  }

}
