# Drupal Europe on Drupal 8

This project is based on the [Drupal project](https://github.com/drupal-composer/drupal-project/blob/8.x/README.md)
composer template and additional information about it can be found in it's README.md file. 

## Local Development setup
There are multiple ways of getting a Local Development setup:

1. The setups recommended by Amazee.io based on their infrastructure. (**recommended**)
  1. Setup either Cachalot or Pygmy as [recommended by Amazee.io](https://docs.amazee.io/local_docker_development/local_docker_development.html)
2. Using [Lando](https://docs.devwithlando.io/) – A configuration for Lando have been included in the code repository and can be initiated by running `lando start`
3. Run your own flavor of Development environment

We are not requiring you to adapt your current favored development environment – but using one of the recommended, allows us better to guide or help you should there be any issues with it.

### 1.1 Pygmy or Cachalot
There is a good step-by-step guide to how to get started with either of these.

- Linux & OS X [Pygmy](https://docs.amazee.io/local_docker_development/pygmy.html)
- OS X [Cachalot](https://docs.amazee.io/local_docker_development/os_x_cachalot.html)

Following the steps there and once ready to boot-up read the after setup steps.

### 2 Lando
Lando is a docker based environment that works on windows, linux and osx – it is fairly easy to get up and running and once installed it just requires a `lando start` in the root folder.

### 3 Your personal flavor of Devleopment environment
If you pick this option we assume you know what you are doing and can figure out issues related to your local environment by your self, but do ask and we can see what we might be able to do.

## Preparing the local installation
First you need to setup the `settings.local.php` file, the `settings.php` file is configured to automatically include it if present.
There is an `example.settings.local.php` file available, it contains the basic required to run the code locally.
A special thing to notice here is that we are using the [Shield module](https://www.drupal.org/project/shield) to project the Develop/Testing server, this gets disabled on production and on your local environment using the configuration in the example.settings.local.php file.

    $config['shield.settings']['credentials'] = [];

Now you are ready for including a database into the project, if you haven't already you need to ping @lslinnet, @ChandeepKhosa or @zelfje on slack and provide your public key so that we can have it added to our hosting setup.
Once you do this you are agreeing to become a data processor with responsibility and by such will be priveleged to personal information about attendees.

    drush sa
    
Will list all Site-aliases, these include those bundled from Amazee.io (`@develop` & `@master`) please do not make use of the `@master` unless you know what you are doing.
To get a working version of the database run:

    drush -y sql-sync @develop @self
    
    drush -y rsync @develop:%files @self:%files

Or as a one-liner.

    drush -y sql-sync @develop @self && drush -y rsync @develop:%files @self:%files

There is also for Pygmy & Cachalot a wrapper script in the containers that helps you with these calls

    dsql @develop
    dfiles @develop
    
Both `dsql` and `dfiles` requires you to be using either cachalot or pygmy.

### Theming
In the theme folder `web/themes/drupaleurope` you will find a package.json file, that should be installed using `npm install`.
When the install is complete it can be started using `npm run watch` which boots the webpack configured compiler and keeps watching for changes.

## Contribute

All changes should be based off the Master branch, Merged into the develop branch for verification and then merged into master once approved.

Testing server can be found at http://example.develop.zh2.compact.amazee.io/ 

    $config['shield.settings']['credentials'] = [
        'shield' => [
            'user' => 'example',
            'pass' => 'example',
        ],
    ];

Additional information about contribution can be found in [CONTRIBUTE.md](CONTRIBUTING.md)
