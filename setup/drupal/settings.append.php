// Do not remove the following line.
/* Settings added by robo setup:drupal */

$config['system.performance']['fast_404']['exclude_paths'] = '/\/(?:styles)|(?:system\/files)\//';
$config['system.performance']['fast_404']['paths'] = '/\.(?:txt|png|gif|jpe?g|css|js|ico|swf|flv|cgi|bat|pl|dll|exe|asp)$/i';
$config['system.performance']['fast_404']['html'] = '<!DOCTYPE html><html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL "@path" was not found on this server.</p></body></html>';

// Trusted host patterns are set in dynamically included files below.
$settings['trusted_host_patterns'] = [];

/**
 * By checking $_ENV['PANTHEON_ENVIRONMENT'] we know whether we are on Pantheon or
 * not and which Acquia environment.
 */
// Load Acquia specific settings files.
if (isset($_ENV['PANTHEON_ENVIRONMENT'])) {
  // Load shared Pantheon settings.
  require_once __DIR__ . '/settings.pantheon-additional.php';
}
// Load settings suitable outside of Acquia (e.g. local development).
else {
  // Load share non-Acquia settings if it exists.
  $non_pantheon_conf_file_path = __DIR__ . '/settings.non-pantheon.php';
  if (file_exists($non_pantheon_conf_file_path)) {
    require_once $non_pantheon_conf_file_path;
  }

  // Load local settings file if it exists.
  $local_conf_file_path = __DIR__ . '/settings.local.php';
  if (file_exists($local_conf_file_path)) {
    require_once $local_conf_file_path;
  }
}
