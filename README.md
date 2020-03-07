# DrupalCamp NYC D8

[drupalcamp.nyc](https://www.drupalcamp.nyc) is hosted on Pantheon. You need to be a member of the DrupalCampNYC Pantheon site's "Team" to be able to:
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
5. `lando start`
6. `lando pull --database=live --files=live`

You now have a fully functional local environment with the latest database and files from the Pantheon site's Live environment, accessible at [https://drupalcampnyc.lndo.site/](https://drupalcampnyc.lndo.site/)

## Useful Commands

`git push` as normal.

Drush: `lando drush <command>`

Drupal Console: `lando drupal <command>`

Overwrite local database and files from Live: `lando pull --database=live --files=live`

Turn off Lando: `lando poweroff`

Start the site: `lando start`

## Enable XDebug

1. Edit .lando.yml and set `xdebug` to `true`.
2. `lando rebuild`

Now everything will run slower :)

## Known Issues

The Ballast toolset is tightly integrated with Composer, which causes problems when using other local environments such as Lando. In particular, settings.local.php is overwritten when certain Composer commands are executed, rendering it useless. Thankfully it is not included by settings.php because `$_ENV['PANTHEON_ENVIRONMENT']` is set by Lando's Pantheon recipe.

# Local Environment Using Ballast
Uses the Ballast local development toolset developed with the support of [Digital Pulp](https://www.digitalpulp.com).

Key contributors:
  - [Shawn Duncan](https://github.com/FatherShawn)
  - [Nick Maine](https://github.com/nickmaine)

## A Composer template for Drupal projects with Docker

This project template automates [Docker](https://www.docker.com/) based local development with [Drupal Composer](https://github.com/drupal-composer/drupal-project) workflows. The local development automation is
currently only optimized for macOS but Linux and possibly Windows
may follow.

- Site dependencies are managed with [Composer](https://getcomposer.org/).
- Setup and management of Docker is automated.

## Getting Started

1. First you need to [install composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx).
   _Note: The instructions below refer to the [global composer installation](https://getcomposer.org/doc/00-intro.md#globally).
     You might need to replace `composer` with `php composer.phar`
     (or similar) for your setup._

2. MacOS users also need to have [Homebrew](https://brew.sh/).

3. Your Docker Sites need a home.
    * Choose or create a file folder to hold all the site folders for projects
managed with this approach.
    * If you have any existing files exported via
NFS they must not be in the chosen folder.
    * The easiest way forward is
to create a new folder such as `~/DockerSites`.


## Install the Project
```
composer install
```
All docker dependencies and Drupal core dependencies along with Drupal
core will be installed.

You should commit all files not excluded by the .gitignore file.

## What does the template do?

When installing the given `composer.json` some tasks are taken care of:

* Drupal will be installed in the `web`-directory.
* Autoloader is implemented to use the generated composer autoloader in
  `vendor/autoload.php`, instead of the one provided by Drupal
  (`web/vendor/autoload.php`).
* Modules (packages of type `drupal-module`) will be placed
  in `web/modules/contrib/`
* Theme (packages of type `drupal-theme`) will be placed
  in `web/themes/contrib/`
* Profiles (packages of type `drupal-profile`) will be placed
  in `web/profiles/contrib/`
* Creates default writable versions of `settings.php`
  and `services.yml`.
* Creates `web/sites/default/files`-directory.
* Latest version of drush is installed locally for use
  at `vendor/bin/drush`.
* Latest version of DrupalConsole is installed locally for use
  at `vendor/bin/drupal`.
* The local machine is checked for dependencies to run the docker
  development setup.  Any missing dependencies are installed
  via homebrew. The following are required for Mac:
    * Ahoy
    * VirtualBox
    * Docker
    * Docker Compose
    * pre-commit by Yelp
    * Docker Machine NFS
* A docker based http-proxy & DNS service is created such that any
  docker container with host name ending in `.dpulp` has traffic routed
  from the host to the proxy.  No editing of /etc/hosts required for
  new projects.

## Updates and Maintenance

### Updating Drupal Core

This project will attempt to keep all of your Drupal Core files
up-to-date; the project [drupal-composer/drupal-scaffold](https://github.com/drupal-composer/drupal-scaffold) is used
to ensure that your scaffold files are updated every time drupal/core
is updated. If you customize any of the "scaffolding" files (commonly
`.htaccess`), you may need to merge conflicts if any of your modified
files are updated in a new release of Drupal core.

Follow the steps below to update your core files.

1. Edit `composer.json` and explicitly set the current version on: `drupal/core` `webflo/drupal-core-strict` `webflo/drupal-core-require-dev`
2. Run `composer update drupal/core webflo/drupal-core-strict webflo/drupal-core-require-dev --with-dependencies` to update
   Drupal Core and its dependencies.
2. Run `git diff` to determine if any of the scaffolding files have
   changed. Review the files for any changes and restore any
   customizations to `.htaccess` or `robots.txt`.
3. Commit everything all together in a single commit, so `web` will
   remain in sync with the `core` when checking out branches or running
   `git bisect`.
4. In the event that there are non-trivial conflicts in step 2, you may
   wish to perform these steps on a branch, and use `git merge`
   to combine the updated core files with your customized files. This
   facilitates the use of a [three-way merge tool such as kdiff3](http://www.gitshah.com/2010/12/how-to-setup-kdiff-as-diff-tool-for-git.html). This
   setup is not necessary if your changes are simple;
   keeping all of your modifications at the beginning or end of the file
   is a good strategy to keep merges easy.

### Updating and maintaining `composer.json`

At the _Managing Drupal Projects with Composer_ BOF at DrupalCon
Baltimore, one of the common pain points was merge conflicts in
`composer.json` and `composer.lock`.  It was the strong consensus of
those gathered that for development teams, there should be one
designated maintainer on the team for these files.  New modules, updates
and so forth should be requested from the maintainer, who is generally
the project lead.

With `composer require ...` you can download new dependencies, including
Drupal contributed modules to your installation. To install the latest
versions of multiple modules:

```
composer require drupal/block_visibility_groups drupal/config_split drupal/easy_breadcrumb drupal/focal_point drupal/media_entity_image drupal/media_entity_browser drupal/field_formatter drupal/paragraphs drupal/inline_entity_form drupal/pathauto drupal/page_manager drupal/viewsreference
```

You also can require bower components:

```
composer require bower-asset/formstone
```
### Local Developement Commands
The docker best practice is to work in the host and send commands to a
container when needed.  This project uses [Ahoy](https://github.com/ahoy-cli/ahoy) as an abstraction tool to
further simplify this flow for developers. Ahoy commands work anywhere
at or below the root directory of the project.

- `ahoy harbor` -  Build the harbor for your docks.  Run this command
  _once_ after the _first time_ you `composer install` a dp-docker project.
- `ahoy cast-off` - Launch the global tools needed for local
  development. Run this command once after you boot your computer.
- `ahoy launch` - Launch this project site.
- `ahoy dock` - Stops this project site and 'returns to port.'
- `ahoy drush command` - Executes _command_ via drush in the site.
- `ahoy drupal command` - Executes _command_ via drupal console
  in the site.
- `ahoy gulp command` - Executes _command_ via gulp in the site theme
  folder.
- `ahoy npm command` - Executes _command_ via npm in the site theme
  folder.
- `ahoy npm-update` - Runs 'npm install' and 'npm-shrinkwrap' in the
  site theme folder.
- `ahoy compile` - Compile the site theme assets.
- `ahoy rebuild env` - Sync with a server database and compile front
  end. Pass an environment argument to use with the drush alias
  (@shortname.env)



### Generate `composer.json` from existing project

With using [the "Composer Generate" drush extension](https://www.drupal.org/project/composer_generate)
you can now generate a basic `composer.json` file from an existing
project. Note that the generated `composer.json` will differ from this
project's file. We recommend comparing the resulting output with this
project's and editing the composer.json to merge them by hand.


## FAQ

### Should I commit the contrib modules I download?

Composer recommends **no**. They provide [argumentation against but also
workrounds if a project decides to do it anyway](https://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md).

### Should I commit the scaffolding files?

The [drupal-scaffold](https://github.com/drupal-composer/drupal-scaffold) plugin can download the scaffold files (like
index.php, update.php, …) to the web/ directory of your project. We
generally commit these. If you have not customized those files you could
choose to not check them into your version control system (e.g. git). If
that is the case for your project it might be convenient to
automatically run the drupal-scaffold plugin after every install or
update of your project. You can achieve that by registering
`@drupal-scaffold` as post-install and post-update command in your
composer.json:

```json
{
"scripts": {
    "drupal-scaffold": "DrupalComposer\\DrupalScaffold\\Plugin::scaffold",
    "post-install-cmd": [
        "@drupal-scaffold",
        "..."
    ],
    "post-update-cmd": [
        "@drupal-scaffold",
        "..."
    ]
  }
}
```
### How can I apply patches to downloaded modules?

If you need to apply patches (depending on the project being modified, a
pull request is often a better solution), you can do so with the
[composer-patches](https://github.com/cweagans/composer-patches) plugin.

To add a patch to drupal module foobar insert the patches section in the
extra section of composer.json:
```json
{
"extra": {
    "patches": {
        "drupal/foobar": {
            "Patch description": "URL to patch"
        }
    }
  }
}
```

## Appreciation
We are grateful for the following open source projects that made this project possible!

- [Drupal](https://www.drupal.org/)
- [Drupal Composer Project](https://github.com/drupal-composer/drupal-project)
- [Drupal Docker](http://www.drupaldocker.org/)
- [Composer](https://getcomposer.org)
- [Robo](http://robo.li/)
- [Ahoy](http://www.ahoycli.com/en/latest/)
