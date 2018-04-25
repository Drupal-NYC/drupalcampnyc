<?php
  /**
   * Pantheon drush alias file, to be placed in your ~/.drush directory or the aliases
   * directory of your local Drush home. Once it's in place, clear drush cache:
   *
   * drush cc drush
   *
   * To see all your available aliases:
   *
   * drush sa
   *
   * See http://helpdesk.getpantheon.com/customer/portal/articles/411388 for details.
   */

  $aliases['drupalcampnyc.dev'] = array(
    'uri' => 'dev-drupalcampnyc.pantheonsite.io',
    'db-url' => 'mysql://pantheon:13dc2ab061174bb9b00366c781b32e32@dbserver.dev.36d6210e-0ea0-4579-9a00-a8d3ef891b81.drush.in:10007/pantheon',
    'db-allows-remote' => TRUE,
    'remote-host' => 'appserver.dev.36d6210e-0ea0-4579-9a00-a8d3ef891b81.drush.in',
    'remote-user' => 'dev.36d6210e-0ea0-4579-9a00-a8d3ef891b81',
    'ssh-options' => '-p 2222 -o "AddressFamily inet"',
    'path-aliases' => array(
      '%files' => 'code/sites/default/files',
      '%drush-script' => 'drush',
     ),
  );
  $aliases['drupalcampnyc.live'] = array(
    'uri' => 'live-drupalcampnyc.pantheonsite.io',
    'db-url' => 'mysql://pantheon:2c41a5affab1472c9fd4d45a1210c5c2@dbserver.live.36d6210e-0ea0-4579-9a00-a8d3ef891b81.drush.in:14933/pantheon',
    'db-allows-remote' => TRUE,
    'remote-host' => 'appserver.live.36d6210e-0ea0-4579-9a00-a8d3ef891b81.drush.in',
    'remote-user' => 'live.36d6210e-0ea0-4579-9a00-a8d3ef891b81',
    'ssh-options' => '-p 2222 -o "AddressFamily inet"',
    'path-aliases' => array(
      '%files' => 'code/sites/default/files',
      '%drush-script' => 'drush',
     ),
  );
  $aliases['drupalcampnyc.test'] = array(
    'uri' => 'test-drupalcampnyc.pantheon.io',
    'db-url' => 'mysql://pantheon:68aa6262aadb4bda94c02b7c54d77da2@dbserver.test.36d6210e-0ea0-4579-9a00-a8d3ef891b81.drush.in:10340/pantheon',
    'db-allows-remote' => TRUE,
    'remote-host' => 'appserver.test.36d6210e-0ea0-4579-9a00-a8d3ef891b81.drush.in',
    'remote-user' => 'test.36d6210e-0ea0-4579-9a00-a8d3ef891b81',
    'ssh-options' => '-p 2222 -o "AddressFamily inet"',
    'path-aliases' => array(
      '%files' => 'code/sites/default/files',
      '%drush-script' => 'drush',
     ),
  );
