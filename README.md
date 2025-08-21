# Drupal 11 starter kit, by Odd Hill AB

This is a starter kit for creating new sites for Drupal with a composer
based workflow, this project is used at [Odd Hill](http://www.oddhill.se/)
when creating new projects.

## Notable features

- Uses [vlucas/phpdotenv](vlucas/phpdotenv) to load local environment configuration.
- Uses the recommended Drupal composer packages to scaffold the project.
- Easy deployments through SSH with GitHub Actions.

## Requirements

The requirements are basically the same as for Drupal 9 but will be set a bit
higher to allow us to take advantage of new language features and more. If you
need to use lower versions everything should work as long as it follows the
Drupal [system requirements](https://www.drupal.org/docs/system-requirements).
You might have to make changes to the CircleCI configuration if you decide to
use other versions.

- [Composer 2.0](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)
- PHP 8.3
- Apache
- MySQL 8.0

## Getting started

### Create

Start by making sure that you have met all the requirements for using the
starter kit. You can then run the following command to create a new project
based on this repository:

```
composer create-project oddhill/drupal-starter-kit ./project-dir --stability dev --no-interaction
```

### Prepare

1. Copy settings.php located in the examples folder to the `public/sites/default`directory.
2. Copy the `.env.default` file located in the project root and rename it to `.env`.
3. Update the environment variables in the `.env` file to match the settings for your local environment.

### Install

When loading the website for the first time you will get an error because
Drupal has not been installed and the database is empty.

To install Drupal you will have to open the `example.localhost/core/install.php`
page in a browser and then go through the installation process.

You now have a new Drupal site installed and configured to use environment
variables, our custom profile, basic deployment and more.

## Adding a theme

You can use any theme with this starter kit but it's recommended to use our
starter theme [oddbady](https://github.com/oddhill/drupal-oddbaby).

## Deployment

Deployment is handled through CircleCI. The deployment script only supports
Linux environments since rsync and SSH is used to perform the deployment.
The deployment also runs various steps that check coding standards in
custom modules and themes as well as build the theme for deployment.

The steps that handles the linting and building of the theme assumes that our
starter theme [oddbady](https://github.com/oddhill/drupal-oddbaby) is used.

Since you will most likely be renaming the theme to fit the specific project
there is a parameter that can easily be changed at the top of the deployment
configuration that will let you set the directory for the theme that should
be used.

### First deployment

The first deployment will be a bit different since the site has not been set up
on the server already. The post deployment step will always fail because of
this and can be temporarily disabled before the first deployment is run and
then be enabled again after the site has been set up.

Since the deployment is done through CircleCI the configuration file needs to
be updated before the first deployment is done. Make sure the correct path has
been set for the theme and that the configuration for the deployment and post
deployment steps have been changed to match the server that the site should be
deployed to.

You will also need the setup the project in CircleCI and add a SSH key to the
project so that the server will allow the SSH connection. Read
[adding an SSH key to CirclecI](https://circleci.com/docs/2.0/add-ssh-key/) if
you have not done this before.

After the site has been deployed for the first time you will have to perform
the following steps to get the site up and running.

1. Copy the `.env.default` file, rename it to `.env` and then edit it and set
   the correct variables for the environment.
2. Create a `.htaccess` file in the `public` folder and paste the contens from
   your local copy of the `.htaccess` file. This is required since the file is
   ignored by rsync during the deployment step.
3. Create the `public/sites/default/files` directory and make sure that the
   permissions for this folder is set to 775.
4. Go to the site by visiting `example.domain/core/install.php` and you should
   now see the installation page. After this is done the site is ready!
