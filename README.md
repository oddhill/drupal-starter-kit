# Odd Drupal 9 starter kit, by Odd Hill AB

This is a starter kit for creating new sites for Drupal 8 with a composer
based workflow, this project is used at [Odd Hill](http://www.oddhill.se/)
when creating new projects.

## Notable features

- Uses [vlucas/phpdotenv](vlucas/phpdotenv) to load local environment configuration.
- Uses the recommended Drupal composer packages to scaffold the project.

## Requirements

- [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
- PHP 7.4
- Apache/Nginx
- MySQL

## Getting started

### Create

Start by making sure that you have met all the requirements for using the
starter kit. You can then run the following command to create a new project
based on this repository:

```
composer create-project oddhill/drupal-starter-kit ./project-dir --stability dev --no-interaction
```

### Prepare

1. Copy settings.php located in the examples folder to the `public/sites/default` directory.
2. Copy the `.env.default` file located in the project root and rename it to `.env`.
3. Upate the environment variables in the `.env` file to match the settings for your local environment.

### Install

TODO
