# Odd Drupal 8 starter kit, by Odd Hill AB

This is a starter kit for creating new sites for Drupal 8 with a composer
based workflow, this project is used at [Odd Hill](http://www.oddhill.se/)
when creating new projects.

## Notable features

- Used vlucas/phpdotenv to load local environment configuration.
- Automatically updates the drupal scaffolding with drupal-composer/drupal-scaffold.

## Getting started

First you need to [install composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx).

After you have installed composer or if you already have composer installed
you can run the following command to get a copy of the starter kit:

```
composer create-project oddhill/drupal-starter-kit ./project-dir --stability dev --no-interaction
```

You should now be able to run the project with your local webserver or with the
supplied Docker configuration.

Depending on how you want to run the project you may have to change the default
settings provided in the `.env` file. 

## Composer scripts

The starter kit includes a few commands that are used when first installing
with composers `create-project`. You can get a list of all the available
commands by running `composer` in a terminal or have a look at the
scripts section in the supplied composer.json file. 
