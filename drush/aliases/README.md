Place drush alias files in this directory.

Place the following snippet at the end of your drushrc.php to automatically pick up these aliases.

/**
 * Load a drushrc file from the 'drush' folder at the root of the current
 * git repository.  Example script below by Grayside.  Customize as desired.
 * @see: http://grayside.org/node/93.
 */
exec('git rev-parse --show-toplevel 2> /dev/null', $output);
if (!empty($output)) {
  $repo = $output[0];
  $options['config'] = $repo . '/drush/drushrc.php';
  $options['include'] = $repo . '/drush/commands';
  $options['alias-path'] = $repo . '/drush/aliases';
}