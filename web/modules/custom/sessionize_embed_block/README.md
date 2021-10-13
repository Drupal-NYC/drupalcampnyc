Sessionize Embed
================

INTRODUCTION
------------

This module allows the display of Sessions, Schedules, and Speakers from [Sessionize.com](https://sessionize.com) on your Drupal 8 or 9 site.

![Sessionize Embed in Drupal 8](https://user-images.githubusercontent.com/1103978/134827378-0da4dce4-1fe7-4368-9cf8-d8693d0c59b2.png)


Sessionize is a cloud-based event planning platform to help event organizers manage Call for Submissions, Speakers and Agenda for conferences.

This module was created for [DrupalCampNYC](https://drupalcamp.nyc) in [2021](https://2021.drupalcamp.nyc),
but we hope that it may be of use to other Drupal event organizers.

The Sessionize Embed module:

* provides a configurable Block for Sessionize embeds
* can be configured to display any of six different styles of embed (including four supported embeds, and two "retired" embeds)

REQUIREMENTS
------------
The initial public release is compatible with Drupal 8 and 9.

INSTALLATION
------------
Install as usual, see [Installing Modules](https://www.drupal.org/docs/extending-drupal/installing-modules) for further information.

CONFIGURATION
-------------
1. Navigate to the settings form through `Admin > Configuration > Web services > Sessionize Embed Block`
or directly at path `/admin/config/services/sessionize_embed_block`
2. Enter your Sessionize web embed ID in the corresponding field.
3. Select an embed style from the dropdown select list.
4. These configuration values define site-wide defaults for a Block which can be added through
the block interface (`Admin > Structure > Block Layout`) to any of your theme's regions.
5. Each Block instance can override the global configuration values with its own version of the Settings Form.

## @todo for official public 0.1.0 release

- Write a better `README`
- Include config form in Block class
- Release module on Drupal.org

## @todo post-launch enhancements
- Expose block config as AJAX overlay to switch ID and style without leaving the page
- Extend module from Embed to full API integration (or maybe that module should just be called Sessionize)

Module categories: Content, Content Display, Third-party Integration
