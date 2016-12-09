<?php

/**
 * @file
 * Contains site specific settings.
 */

/**
 * Load environment variables.
 */
$dotenv = new Dotenv\Dotenv(DRUPAL_ROOT . '/../');
$dotenv->load();

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
 * Location of the site configuration files.
 */
$config_directories = [
  CONFIG_SYNC_DIRECTORY => DRUPAL_ROOT . '/../config',
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
 * Show all error messages, with backtrace information.
 *
 * In case the error level could not be fetched from the database, as for
 * example the database connection failed, we rely only on this value.
 */
# $config['system.logging']['error_level'] = 'verbose';

/**
 * Enable access to rebuild.php.
 *
 * This setting can be enabled to allow Drupal's php and database cached
 * storage to be cleared via the rebuild.php page. Access to this page can also
 * be gained by generating a query string from rebuild_token_calculator.sh and
 * using these parameters in a request to rebuild.php.
 */
# $settings['rebuild_access'] = TRUE;

/**
* Load services definition file.
*/
$settings['container_yamls'][] = __DIR__ . '/services.yml';

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
$environments = ['local', 'development', 'staging', 'production'];

foreach ($environments as $environment) {
  if (file_exists(__DIR__ . "/settings.{$environment}.php")) {
    include __DIR__ . "/settings.{$environment}.php";
  }
}
