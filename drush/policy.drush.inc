<?php

/**
 * Implements drush_hook_COMMAND_validate().
 *
 * Deny updating core and contrib projects.
 */
function drush_policy_pm_updatecode_validate() {
  return _deny_message();
}

/**
 * Implements drush_hook_COMMAND_validate().
 *
 * Deny updating core or projects with Drush.
 *
 * @return mixed
 */
function drush_policy_pm_update_validate() {
  return _deny_message();
}

/**
 * Implements drush_hook_COMMAND_validate().
 *
 * Deny downloading projects with Drush.
 *
 * @return mixed
 */
function drush_policy_pm_download_validate() {
  return _deny_message();
}

/**
 * Alter the Drush help to add the pm-force command.
 *
 * Implements hook_drush_help_alter().
 */
function policy_drush_help_alter(&$command) {
  if (in_array($command['command'], ['pm-updatecode', 'pm-update', 'pm-download'])) {
    $command['options']['pm-force'] = 'Override safeguards against Drush pm-commands.';
  }
}

/**
 * Message to show when denying Drush actions.
 *
 * @return mixed
 */
function _deny_message() {
  if (!drush_get_option('pm-force')) {
    $message = 'This project is managed by composer, because of this Drush should not be used to download or update projects and core. Please use the appropriate compsoser commands instead to download and update code.';
    return drush_set_error('POLICY_PM_DENY', dt($message));
  }
}

