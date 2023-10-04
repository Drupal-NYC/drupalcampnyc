# DrupalCampNYC Website

Anyone can install this website locally even without being involved in DrupalCampNYC, but the website will have no content and the frontpage will point to a nonexistent page node until you create content and change the frontpage configuration.

# DrupalCampNYC DevOps

[drupalcamp.nyc](https://www.drupalcamp.nyc) is hosted on Amazee. You need to be a member of the DrupalCampNYC site's "Team" to be able to:
* Make a manual backup of the site
* Download a copy of the site's database and/or files (sites/default/files)

[Our canonical git repository](https://github.com/Drupal-NYC/drupalcampnyc) is on GitHub. You need to be a member of the GitHub Drupal-NYC organization's [DrupalCamp team](https://github.com/orgs/Drupal-NYC/teams/drupalcamp) (link only works if you are a member) in order to:
* Push changes to the master branch
* Approve pull requests

Our [.gitignore file](web/.gitignore) is constructed to prevent "built" files such as those managed by Composer (e.g. Drupal core, contrib modules, and the vendor directory) or other package managers and build tools (e.g. theme dependencies and theme assets) from being added to the repository.

When changes are pushed to or merged into the master branch on GitHub, a build should be triggered on Amazee's Lagoon system. You need to be a member of the DrupalCampNYC site's "Team" to:
view the status of builds, but status messages about builds are also posted in the #hosting channel of [DrupalNYC Slack](https://www.drupalnyc.org/slack).

# Local Environment Using DDEV

[DDEV documentation](https://ddev.readthedocs.io/en/stable/)

## Initial Setup

Note that the git repo already has a `.ddev` directory so you only need DDEV installed locally to get started.

1. Follow the instructions for your operating system to [setup DDEV on your local machine](https://ddev.readthedocs.io/en/stable/)
2. Create a directory to contain the site (e.g. `mkdir ~/Sites/drupalcampnyc`). To avoid file permission issues, it is strongly recommended that this directory be located within your home folder.
3. Change to that directory (e.g. `cd ~/Sites/drupalcampnyc`)
4. If you have your local SSH public key [added to your GitHub account](https://help.github.com/en/github/authenticating-to-github/adding-a-new-ssh-key-to-your-github-account) (recommended), clone the repository using:

   `git clone git@github.com:Drupal-NYC/drupalcampnyc.git .`

   Otherwise, clone using HTTPS:

   `git clone https://github.com/Drupal-NYC/drupalcampnyc.git .`

5. Start the project by first starting up your docker system, if needed for your OS, and then `ddev start`.
6. Get dependencies by running `ddev rebuild` Note the following commands are run inside the container:
   * `composer install` for the project
   * `npm install` in web/themes/drupalnyc
   * `npm run build` in web/themes/drupalnyc to compile the theme

`ddev rebuild` is defined in .ddev/commands/web/rebuild

7. For a fresh Drupal installation that takes advantage of all the configuration that has already been done, install from config:

   `ddev drush si minimal --existing-config`

   Note: installing from config can easily take 10 minutes to complete.

   If you are a member of DrupalCampNYC site's "Team", you probably instead want to "Refresh from Amazee Lagoon" per the next section.

## Refresh from Amazee Lagoon
If you haven't already, forward your ssh keys into the container using `ddev auth ssh`.

To replace your local environment's database and files with that of our Live environment: `ddev update`

`ddev update` is defined in .ddev/commands/host/update and runs the following commands so that you don't have to run them individually.
1. `drush rsync @lagoon.main:%files  @self:%files`
2.  `drush sql-sync @lagoon.main @self`
3.  `drush deploy`

Note that this will overwrite your local database and files without prompt. The `drush deploy` ensures that your local environment uses the development-specific configuration.

You now have a fully functional local environment, accessible at [https://drupalcampnyc.lndo.site/](https://drupalcampnyc.lndo.site/)

If you find that you can see the site, but the theme was not applied, check out your error/warning messages in the console.  You may be asked to install a module called optipng.  Use this command to install it:  `npm install --save optipng-bin`

## Lagoon environments

### Main
This is the production environment.  The `main` branch is deployed here.

### Test
A staging environment that deploys the `test` branch.

### Pull Requests
A PR to either of `main` or `test` will spin up a temporary environment with the result of
the PR deployed as the code.  We are allowed up to 3 of these temporary environments.

## Useful Commands

`git push` as normal.

The following commands must be run with their ddev prefix so that they are run inside the Lando container.

Composer: `ddev composer <command>`

Drush: `ddev drush <command>`

## Using XDebug

XDebug debugging is disabled for performance reasons. `ddev xdebug on` will enable Xdebug.

## Using Composer

You should run composer inside the DDEV container by using `ddev composer` instead of `composer`.

If you prefer to run composer on the host (and use `composer`) rather than have to use `ddev composer`, you must
have the same version of PHP as that used in the container.

Lando's [Performance documentation](https://docs.lando.dev/config/performance.html) explains further.

### Composer Scaffold

We use Drupal's [core-composer-scaffold](https://github.com/drupal/core-composer-scaffold) to place and manage files provided by Drupal core or Pantheon.


# Credits

We are grateful to Drupal Europe 2018 for providing their [codebase](https://www.drupal.org/project/drupaleurope_website), which we adopted and improved upon.

# Collaborate
To collaborate in real-time, please join us in the #camp-website channel of [DrupalNYC Slack](https://www.drupalnyc.org/slack).

To collaborate with us and other camps on a shared codebase for future camps, please join us in the #event-website-starterkit channel of the [Drupal Event Organizers](https://www.drupal.org/community/event-organizers) Slack.

We encourage merge requests.
