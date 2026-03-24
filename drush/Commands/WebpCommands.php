<?php

namespace Drush\Commands;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\image\Entity\ImageStyle;
use Drush\Attributes as CLI;
use Drush\Commands\DrushCommands;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Drush commands for WebP image conversion.
 */
final class WebpCommands extends DrushCommands {

  /**
   * Constructs a WebpCommands object.
   */
  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
  ) {
    parent::__construct();
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
    );
  }

  /**
   * Enable AVIF conversion (with WebP fallback) for all image styles.
   */
  #[CLI\Command(name: 'image-styles:optimize', aliases: ['iso'])]
  #[CLI\Usage(name: 'drush image-styles:optimize', description: 'Enable AVIF conversion (with WebP fallback) for all image styles')]
  public function optimizeImageStyles(): void {
    $imageStyleStorage = $this->entityTypeManager->getStorage('image_style');
    $imageStyles = $imageStyleStorage->loadMultiple();

    if (empty($imageStyles)) {
      $this->output()->writeln('<comment>No image styles found.</comment>');
      return;
    }

    $this->output()->writeln('Optimizing all image styles with AVIF (WebP fallback)...');
    $this->output()->writeln('');

    $count = 0;
    /** @var \Drupal\image\Entity\ImageStyle $style */
    foreach ($imageStyles as $style) {
      // Check if any conversion effect already exists.
      $hasConversion = FALSE;
      $conversionType = NULL;
      foreach ($style->getEffects() as $effect) {
        if ($effect->getPluginId() === 'image_convert') {
          $hasConversion = TRUE;
          $config = $effect->getConfiguration();
          $conversionType = $config['data']['extension'] ?? 'unknown';
          break;
        }
        if ($effect->getPluginId() === 'image_convert_avif') {
          $hasConversion = TRUE;
          $conversionType = 'avif';
          break;
        }
      }

      if (!$hasConversion) {
        // Add AVIF conversion effect with WebP fallback at the end.
        $style->addImageEffect([
          'id' => 'image_convert_avif',
          'weight' => 100,
          'data' => [
            'extension' => 'webp',
          ],
        ]);
        $style->save();
        $count++;
        $this->output()->writeln("✓ {$style->label()} ({$style->id()})");
      }
      else {
        $this->output()->writeln("- {$style->label()} (already has {$conversionType} conversion)");
      }
    }

    $this->output()->writeln('');
    if ($count > 0) {
      $this->output()->writeln("<info>Successfully optimized {$count} image style(s) with AVIF+WebP.</info>");
      $this->output()->writeln('<comment>Run "drush cr" to clear caches.</comment>');
    }
    else {
      $this->output()->writeln('<comment>All image styles are already optimized.</comment>');
    }
  }

}
