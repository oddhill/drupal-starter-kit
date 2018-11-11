<?php

/**
 * @file
 * Contains site specific settings.
 */

use Symfony\Component\Debug\Debug;

/**
 * Load environment variables.
 */
$dotenv = new Dotenv\Dotenv($app_root . '/../');
$dotenv->load();

/**
 * Enable improved debugging in the development environment.
 */
if (getenv('APP_ENV') === 'development') {
  Debug::enable();
}

/**
 * Database settings.
 */
$databases['default']['default'] = [
  'database' => getenv('DB_DATABASE'),
  'username' => getenv('DB_USERNAME'),
  'password' => getenv('DB_PASSWORD'),
  'host' => getenv('DB_HOST'),
  'port' => getenv('DB_PORT'),
  'prefix' => '',
  'driver' => 'mysql',
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
];

/**
 * Activate Reroute Email if environment hasn't been set to production.
 *
 * These settings will make sure that no emails are sent for environments other
 * than production, but you'll need to copy these to settings.local.php in order
 * to reroute to an address which you've got access to.
 */
if (getenv('APP_ENV') !== 'production') {
  $config['reroute_email.settings']['reroute_email_enable'] = TRUE;
  $config['reroute_email.settings']['reroute_email_address'] = getenv('REROUTE_EMAIL_ADDRESS');
  $config['reroute_email.settings']['reroute_email_enable_message'] = TRUE;
}

/**
 * Location of the site configuration files.
 */
$config_directories = [
  CONFIG_SYNC_DIRECTORY => $app_root . '/../config',
];

/**
 * Salt for one-time login links, cancel links, form tokens, etc.
 */
$settings['hash_salt'] = getenv('APP_KEY');

/**
 * The active installation profile.
 *
 * Changing this after installation is not recommended as it changes which
 * directories are scanned during extension discovery. If this is set prior to
 * installation this value will be rewritten according to the profile selected
 * by the user.
 *
 * @see install_select_profile()
 */
$settings['install_profile'] = '';

/**
 * Load services definition file.
 */
$settings['container_yamls'][] = $app_root . '/' . $site_path . '/services.yml';

/**
 * Load local development override configuration, if available.
 *
 * Use settings.local.php to override variables on secondary (staging,
 * development, etc) installations of this site. Typically used to disable
 * caching, JavaScript/CSS compression, re-routing of outgoing emails, and
 * other things that should not happen on development and testing sites.
 *
 * Keep this code block at the end of this file to take full effect.
 */
if (file_exists($app_root . '/' . $site_path . '/settings.local.php')) {
  include $app_root . '/' . $site_path . '/settings.local.php';
}
