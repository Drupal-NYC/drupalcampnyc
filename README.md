# DrupalCampNYC Website

Anyone can install this website locally even without being involved in DrupalCampNYC, but the website will have no content and the frontpage will point to a nonexistent page node until you create content and change the frontpage configuration.

# DrupalCampNYC DevOps

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

*** If you are using an Apple laptop with the M1 chip, make sure you have this version of PHP installed: `PHP 7.3.27`  You can check your version by using :  `php -v`.   Do not upgrade to PHP 8.0!  The installation of the environment for M1 will not work with that version.

# Local Environment Using Lando

[Lando documentation](https://docs.lando.dev/)

## Initial Setup

Note that the git repo already has a `.lando.yml` file so you shouldn't run `lando init`.

1. Download and install the [latest release of Lando](https://github.com/lando/lando/releases/latest)
2. *** If you are running laptop with the Apple M1 chip please note: the lando installation will also install Docker for the intel chip.  This will cause an error on your machine.  You must install the M1 version of Docker.  This should overwrite the one installed by Lando.  It can be found here:  (https://desktop.docker.com/mac/stable/arm64/Docker.dmg?utm_source=docker&utm_medium=webreferral&utm_campaign=docs-driven-download-mac-arm64).
3. Create a directory to contain the site (e.g. `mkdir ~/Sites/drupalcampnyc`). To avoid file permission issues, it is strongly recommended that this directory be located within your home folder.
4. Change to that directory (e.g. `cd ~/Sites/drupalcampnyc`)
5. If you have your local SSH public key [added to your GitHub account](https://help.github.com/en/github/authenticating-to-github/adding-a-new-ssh-key-to-your-github-account) (recommended), clone the repository using:

   `git clone git@github.com:Drupal-NYC/drupalcampnyc.git .`

   Otherwise, clone using HTTPS:

   `git clone https://github.com/Drupal-NYC/drupalcampnyc.git .`

5. If you are a member (on Pantheon) of the DrupalCampNYC Pantheon site's "Team", copy the Pantheon-enabled local Lando config:

   `cp setup/lando-pantheon/.lando.local.yml .`

   And be sure that you have [uploaded your public SSH key to Pantheon](https://pantheon.io/docs/ssh-keys#add-your-ssh-key-to-pantheon).

   Otherwise, copy the non-Pantheon local Lando config:

   `cp setup/lando-basic/.lando.local.yml .`

6. `lando start`

   Note (don't run these commands): per .lando.yml and .lando.local.yml, when `lando start` is run for the first time and whenever `lando rebuild` is run, the following commands are run inside the container:
   * `composer install` for the project
   * `npm install` in web/themes/drupalnyc
   * `npm run build` in web/themes/drupalnyc to compile the theme

7. For a fresh Drupal installation that takes advantage of all the configuration that has already been done, install from config:

   `lando drush si minimal --existing-config`

   Note: installing from config can easily take 10 minutes to complete.

   If you are a member (on Pantheon) of the DrupalCampNYC Pantheon site's "Team", you probably instead want to "Refresh from Pantheon" per the next section.

## Refresh from Pantheon

To replace your local environment's database and files with that of our Live environment, ensure that you are using the Pantheon lando.local.yml described under "Initial Setup" above, ensure that you are a member of the Pantheon site's "Team", then:
1. `lando pull`
2. `lando update`

`lando update` is defined in .lando.yml and runs the following commands so that you don't have to run them individually.
1. `lando composer install`
2. `lando drush cr`
3. `lando drush updb`
4. `lando drush cim`

Note that this will overwrite your local database and files without prompt. The `lando drush cim` ensures that your local environment uses the development-specific configuration (e.g. enables Devel).

You now have a fully functional local environment, accessible at [https://drupalcampnyc.lndo.site/](https://drupalcampnyc.lndo.site/)

If you find that you can see the site, but the theme was not applied, check out your error/warning messages in the console.  You may be asked to install a module called optipng.  Use this command to install it:  `npm install --save optipng-bin`

## Useful Commands

`git push` as normal.

The following commands must be run with their lando prefix so that they are run inside the Lando container.

Composer: `lando composer <command>`

Drush: `lando drush <command>`

Drupal Console: `lando drupal <command>`

Turn off Lando: `lando poweroff`

Start the site: `lando start`

Build the theme: `lando npm run build`

Build the theme automatically when changed: `lando npm run watch`

Get a one-time log in URL for user 1: `lando drush uli`

## Using XDebug

XDebug debugging is enabled, but for performance reasons, [start_with_request](https://xdebug.org/docs/all_settings#start_with_request) is set to "trigger" so you'll need to trigger XDEBUG per request. Alternatively you can create a custom php.ini based on .lando/php.ini and [override](https://docs.lando.dev/config/lando.html#override-file) the active php.ini in .lando.local.yml (which you may need to create).

## Using Composer

You must run composer inside the Lando container by using `lando composer` instead of `composer`.

Why? For performance reasons, lando.yml is configured to disable syncing of files in the `vendor` and `node_modules` directories. For this reason, running vanilla `composer` commands in your terminal will not behave as expected.

If you prefer to take the performance hit (and use `composer`) rather than have to use `lando composer`, you should be able to override the excludes in lando.local.yml by adding an exclude similar to `"!vendor"`.

Lando's [Performance documentation](https://docs.lando.dev/config/performance.html) explains further.

### Composer Scaffold

We use Drupal's [core-composer-scaffold](https://github.com/drupal/core-composer-scaffold) to place and manage files provided by Drupal core or Pantheon.

# Tome Netlify Demo (for DevOps Summit)

## Local Drupal + Netlify

This guide will describe how you can use traditional Drupal hosting, Tome Static, and Netlify to have a normal content editing experience while still running static html on your public-facing site.

First, you'll need to create a local development environment. For this demo, I'll use Lando since it's the local dev environment for the DrupalCampNYC site.

(Run `lando start` on WSL2.)

Assuming you have your local Drupal 8 up and running, run this command from where your site's "composer.json" file lives: "composer require drupal/tome drupal/tome_netlify".

Edit your site "settings.php" file and set the "tome_static_directory" setting to a writeable directory on your hosting provider.

Tome documentation recommends adding the following block of code for sites hosted on Pantheon:

```php
if (isset($_ENV['PANTHEON_ENVIRONMENT'])) {
  $settings['tome_static_directory'] = 'sites/default/files/private/tome_static';
}
```

However, we want the ability to export directly from Lando, so we won't even check the Pantheon environment variable:

```php
// Configure Tome Static directory for Tome Netlify.
$settings['tome_static_directory'] = 'sites/default/files/private/tome_static';

```

The rest of the instructions are quoted verbatim from [Tome documentation](https://tome.fyi/docs/hosting/hosted-drupal-netlify/):

> Commit the changes and push to your remote repository if you're using version control.
>
> Create a Netlify account at https://app.netlify.com/signup
>
> Login to  your Drupal site as an administrator. Ensure you are using the HTTPS URL of your Drupal site, as Netlify pushes will fail when using HTTP.
>
> Enable Tome Static and Tome Netlify at /admin/modules. You're enabling Tome Static and not Tome since you don't need any of the "store your content in Git" features that Tome Sync provides.
>
> Visit `/admin/config/tome/static/generate` and generate your first static site.
>
> Visit `/admin/config/tome/static/download` and download the static build. Extract the generated .tar.gz file.
>
> Visit https://app.netlify.com/account/sites and drag+drop your static build folder to the dropzone at the bottom of the screen. This will create a new Netlify site that isn't tracked in Git.
>
> Click into your new site in the Netlify UI, then click "Settings". Copy your site-specific "API ID" from there.
>
> Visit https://app.netlify.com/account/applications and generate a new personal access token. Copy your token as it can not be retrieved after viewing it the first time.
>
> Visit `/admin/config/services/tome_netlify/settings` and enter your token and site ID, then save the form.
>
> Visit `/admin/config/tome/netlify/send` and click Deploy.
>
> Wait a few minutes after a deploy is complete for Netlify to pick up the new build, then preview it using the link provided. Builds sent to Netlify only include files that have changed since the last build, which should make them super-duper fast.
>
> When satisfied with the deploy, publish the draft on Netlify at "Deploys" when viewing your site in the UI.
>
> You're done!
>
> While this guide may seem daunting, I think this hosting setup is the most reasonable for Drupal users who don't want to change the way content editors use Drupal, but still want to run a static site on the frontend.



# Credits

We are grateful to Drupal Europe 2018 for providing their [codebase](https://www.drupal.org/project/drupaleurope_website), which we adopted and improved upon.

# Collaborate
To collaborate in real-time, please join us in the #camp-website channel of [DrupalNYC Slack](https://www.drupalnyc.org/slack).

To collaborate with us and other camps on a shared codebase for future camps, please join us in the #event-website-starterkit channel of the [Drupal Event Organizers](https://www.drupal.org/community/event-organizers) Slack.

We encourage merge requests.
