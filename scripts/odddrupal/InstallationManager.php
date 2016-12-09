<?php

namespace OddDrupal;

use Composer\Script\Event;
use Symfony\Component\Filesystem\Filesystem;

class InstallationManager {

  /**
   * Directories to create if they do not exist.
   *
   * @var array
   */
  protected static $directories = [
    'modules',
    'profiles',
    'themes',
  ];

  /**
   * Get the project root.
   *
   * @return string
   */
  protected static function getDrupalRoot() {
    return self::getCurrentWorkdingDirectory() . '/public';
  }

  /**
   * Get the current working directory.
   *
   * @return string
   */
  protected static function getCurrentWorkdingDirectory() {
    return getcwd();
  }

  /**
   * Create the required files and directories for a Drupal project.
   *
   * @param Event $event
   */
  public static function createRequiredFiles(Event $event) {
    $fs = new Filesystem();

    self::createDirectories($fs);
    self::prepareSettingsFile($event, $fs);
    self::prepareServicesFile($event, $fs);
    self::createFilesDirectory($event, $fs);
  }

  /**
   * Creates the local environment variables file if one does not exist.
   *
   * @param Event $event
   * @param Filesystem $fs
   */
  protected static function copyEnvironmentVariables(Event $event, Filesystem $fs) {
    $cwd = self::getCurrentWorkdingDirectory();

    if ($fs->exists("{$cwd}/.env.default")) {
      return;
    }

    $fs->copy("{$cwd}/.env.default", "{$cwd}/.env");

    $event->getIO()->write("Copied the default '.env.default' file to the local '.env' file.");
  }

  /**
   * Creates the directories defined in the directories array if they do not
   * exist.
   *
   * @param Filesystem $fs
   */
  protected static function createDirectories(Filesystem $fs) {
    $root = self::getDrupalRoot();

    foreach (self::$directories as $directory) {
      if ($fs->exists("{$root}/{$directory}")) {
        continue;
      }

      $fs->mkdir("{$root}/{$directory}");
      $fs->touch("{$root}/{$directory}/.gitkeep");
    }
  }

  /**
   * Creates the files directory if it does not already exist.
   *
   * @param Event $event
   * @param Filesystem $fs
   */
  protected static function createFilesDirectory(Event $event, Filesystem $fs) {
    $root = self::getDrupalRoot();

    if ($fs->exists("{$root}/sites/default/files")) {
      return;
    }

    $old_mask = umask(0);
    $fs->mkdir("{$root}/sites/default/files", 0777);
    umask($old_mask);

    $event->getIO()->write("Created the 'sites/default/files' directory with chmod 0777");
  }

  /**
   * Prepare the project settings file if it does not already exist.
   *
   * @param Event $event
   * @param Filesystem $fs
   */
  protected static function prepareSettingsFile(Event $event, Filesystem $fs) {
    $root = self::getDrupalRoot();

    if ($fs->exists("{$root}/sites/default/settings.php") && $fs->exists("{$root}/sites/default/default.settings.php")) {
      return;
    }

    $fs->copy(__DIR__ . "/templates/settings.php", "{$root}/sites/default/settings.php");
    $fs->chmod("{$root}/sites/default/settings.php", 0666);

    $event->getIO()->write("Created the 'sites/default/settings.php' file with chmod 0666");
  }

  /**
   * Prepare the project services file if it does not already exist.
   *
   * @param Event $event
   * @param Filesystem $fs
   */
  protected static function prepareServicesFile(Event $event, Filesystem $fs) {
    $root = self::getDrupalRoot();

    if ($fs->exists("{$root}/sites/default/services.yml") && $fs->exists("{$root}/sites/default/default.services.yml")) {
      return;
    }

    $fs->copy("{$root}/sites/default/default.services.yml", "{$root}/sites/default/services.yml");
    $fs->chmod("{$root}/sites/default/services.yml", 0666);

    $event->getIO()->write("Created the 'sites/default/services.yml' file with chmod 0666");
  }
}
