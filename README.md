# DrupalCamp NYC D8

[drupalcamp.nyc](https://www.drupalcamp.nyc) is hosted on Pantheon. You need to be a member of the [DrupalCampNYC Pantheon site's "Team"](https://dashboard.pantheon.io/sites/36d6210e-0ea0-4579-9a00-a8d3ef891b81) (link only works if you are a member) to be able to:
* Make a manual backup of the site
* Download a copy of the site's database and/or files (sites/default/files)
* Deploy to Pantheon's Test or Stage environment

[Our canonical git repository](https://github.com/Drupal-NYC/drupalcampnyc) is on GitHub. You need to be a member of the GitHub Drupal-NYC organization's [DrupalCamp team](https://github.com/orgs/Drupal-NYC/teams/drupalcamp) (link only works if you are a member) in order to:
* Push changes to the master branch
* Approve pull requests

When changes are pushed to or merged into the master branch on GitHub, a build should be triggered on CodeShip. You need to be a member of the Drupalnyc [Devs CodeShip team](https://app.codeship.com/orgs/drupalnyc/teams/devs) (link only works if you are a member) to:
* [View build status and history](https://app.codeship.com/projects/1ea10500-2c56-0136-bbdc-5ed18f0e55cd)

The CodeShip build, among other things, deploys the changes to our Pantheon site's Dev environment.

# Local Environment Using Lando

[Lando documentation](https://docs.lando.dev/)

## Initial Setup

Note that the git repo already has a `.lando.yml` file so you shouldn't run `lando init`.

1. Download and install the latest release of Lando from https://github.com/lando/lando/releases
2. Create a directory to contain the site (e.g. `mkdir ~/Sites/drupalcampnyc`)
3. Change to that directory (e.g. `cd ~/Sites/drupalcampnyc`)
4. `git clone git@github.com:Drupal-NYC/drupalcampnyc.git .`
5. `git checkout drupaleurope`
6. `lando start`
7. Go to https://drupalcampnyc.lndo.site/ and install Drupal "from configuration" (slower) or import a starter database from setup/db (faster).

The first time it is run, per .lando.yml, `lando start`:
* runs `composer install` for the project
* runs `npm install` in web/themes/drupaleurope
* runs `npm run build` in web/themes/drupaleurope to compile the theme

You now have a fully functional local environment, accessible at [https://drupalcampnyc.lndo.site/](https://drupalcampnyc.lndo.site/)

## Useful Commands

`git push` as normal.

Drush: `lando drush <command>`

Drupal Console: `lando drupal <command>`

Turn off Lando: `lando poweroff`

Start the site: `lando start`

Build the theme: `lando npm run build`

Build the theme automatically when changed: `lando npm run watch`

## Enable XDebug

1. Edit .lando.yml and set `xdebug` to `true`.
2. `lando rebuild`

Now everything will run slower :)
