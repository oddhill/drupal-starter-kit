# Odd Drupal 8 starter kit, by Odd Hill AB

This is a starter kit for creating new sites for Drupal 8 with a composer based workflow, this project is used at [http://www.oddhill.se/](Odd Hill) when creating new projects.

## Notable features

- Used vlucas/phpdotenv to load local environment configuration.
- Automatically updates the drupal scaffolding with drupal-composer/drupal-scaffold.

## Getting started

First you need to [https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx](install composer).

After you have installed composer or if you already have composer installed you can run the following command to get a copy of the starter kit:

```
composer create-project oddhill/drupal-starter-kit ./project-dir --stability dev --no-interaction
```

## Composer scripts

The starter kit includes a few commands that are used when first installing with composers `create-project`
