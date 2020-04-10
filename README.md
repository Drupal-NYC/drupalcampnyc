# DrupalCamp NYC D8

[drupalcamp.nyc](https://www.drupalcamp.nyc) is hosted on Pantheon. You need to be a member of the [DrupalCampNYC Pantheon site's "Team"](https://dashboard.pantheon.io/sites/36d6210e-0ea0-4579-9a00-a8d3ef891b81) (link only works if you are a member) to be able to:
* Make a manual backup of the site
* Download a copy of the site's database and/or files (sites/default/files)
* Deploy to Pantheon's Test or Stage environment

[Our canonical git repository](https://github.com/Drupal-NYC/drupalcampnyc) is on GitHub. You need to be a member of the GitHub Drupal-NYC organization's [DrupalCamp team](https://github.com/orgs/Drupal-NYC/teams/drupalcamp) (link only works if you are a member) in order to:
* Push changes to the master branch
* Approve pull requests

Our [.gitignore file](web/.gitignore) is constructed to prevent "built" files such as those managed by Composer (e.g. Drupal core, contrib modules, and the vendor directory) or other package managers and build tools (e.g. theme dependencies and theme assets) from being added to the repository.

When changes are pushed to or merged into the master branch on GitHub, a build should be triggered on CodeShip. You need to be a member of the Drupalnyc [Devs CodeShip team](https://app.codeship.com/orgs/drupalnyc/teams/devs) (link only works if you are a member) to:
* [View build status and history](https://app.codeship.com/projects/1ea10500-2c56-0136-bbdc-5ed18f0e55cd)

CodeShip, among other things, runs `composer install` and `npm run build`, copies the GitHub repo and the newly built files to the master branch of our Pantheon site's git repository, and performs additional steps to deploy the changes to our Pantheon Dev environment.

Our use of CodeShip for CI has many benefits, but one side effect is that we can't use Pantheon's environments to make any changes to configuration (e.g. site building) because there is no good way to get those changes back to our canonical git repository in GitHub. Thus, we must use local development environments to make configuration changes.

# Local Environment Using Lando

[Lando documentation](https://docs.lando.dev/)

## Initial Setup

Note that the git repo already has a `.lando.yml` file so you shouldn't run `lando init`.

1. Download and install the latest release of Lando from https://github.com/lando/lando/releases/latest
2. Create a directory to contain the site (e.g. `mkdir ~/Sites/drupalcampnyc`)
3. Change to that directory (e.g. `cd ~/Sites/drupalcampnyc`)
4. If you have your local SSH public key [added to your GitHub account](https://help.github.com/en/github/authenticating-to-github/adding-a-new-ssh-key-to-your-github-account) (recommended), clone the repository using:

   `git clone git@github.com:Drupal-NYC/drupalcampnyc.git .`

   Otherwise, clone using HTTPS:

   `git clone https://github.com/Drupal-NYC/drupalcampnyc.git .`

5. `git checkout drupaleurope`
6. If you are a member (on Pantheon) of the DrupalCampNYC Pantheon site's "Team", copy the Pantheon-enabled local Lando config:

    `cp setup/lando-pantheon/.lando.local.yml .`

    Otherwise, copy the non-Pantheon local Lando config:

    `cp setup/lando-basic/.lando.local.yml .`

7. `lando start`

    Per .lando.yml and .lando.local.yml, when `lando start` is run for the first time and whenever `lando rebuild` is run, the following commands are run inside the container:
    * `composer install` for the project
    * `npm install` in web/themes/drupaleurope
    * `npm run build` in web/themes/drupaleurope to compile the theme

8. Time to install Drupal. We want to take advantage of all the configuration that has already been done so we are going to install from config:

    `lando drush si minimal --existing-config`

    Note: installing from config can easily take 10 minutes to complete.

    Alternatively, to save some time and to see some basic content, you can import the latest starter database from the directory setup/db. For example:

    `lando db-import setup/db/2020-04-10.sql.gz`

You now have a fully functional local environment, accessible at [https://drupalcampnyc.lndo.site/](https://drupalcampnyc.lndo.site/)

## Useful Commands

`git push` as normal.

Drush: `lando drush <command>`

Drupal Console: `lando drupal <command>`

Turn off Lando: `lando poweroff`

Start the site: `lando start`

Build the theme: `lando npm run build`

Build the theme automatically when changed: `lando npm run watch`

Get a one-time log in URL for user 1: `lando drush uli`

## Enable XDebug

1. Edit .lando.local.yml and set `xdebug` to `true`.
2. `lando rebuild`

Now everything will run slower :)
