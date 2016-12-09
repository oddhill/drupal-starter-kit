<?php

namespace OddDrupal;

use Composer\Script\Event;
use Drupal\Component\Utility\Crypt;

class KeyGenerator {

  /**
   * Get the path to the file containing the environment variables.
   *
   * @return string
   */
  protected static function getEnvironmentFilePath() {
    return getcwd() . '/.env';
  }

  /**
   * Loads encryption polyfills required by Drupal to be able to run the
   * random_bytes() function when generating the app key.
   */
  protected static function loadEncyptionPolyfill() {
    require_once getcwd() . '/vendor/paragonie/random_compat/lib/random.php';
  }

  /**
   * Generates a new app key.
   *
   * @param Event $event
   */
  public static function generateAppKey(Event $event) {
    self::loadEncyptionPolyfill();

    // Generate the random key.
    $key = Crypt::randomBytesBase64(55);
    $env_path = self::getEnvironmentFilePath();

    // Replace the current app key with a new one.
    try {
      $content = preg_replace('/APP_KEY=.*/', "APP_KEY={$key}", file_get_contents($env_path));

      // Write the new environment file with the key.
      file_put_contents($env_path, $content);

      $event->getIO()->write('Application key set successfully.');
    }
    catch (\Exception $e) {
      $event->getIO()->write('Failed to write the application key. Make sure the dotenv file exists.');
    }
  }
}
