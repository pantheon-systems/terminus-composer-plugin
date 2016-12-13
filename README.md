# Terminus Drupal Console

Terminus Plugin to run [Drupal Console](https://github.com/hechoendrupal/DrupalConsole) commands on a [Pantheon](https://www.pantheon.io) sites.

Adds a command 'drupal' to Terminus 1.x which you can use just like 'drush' or 'wp'.

This project is based on the `drush` and `wp` commands from Terminus core.

## Configuration

In order for the Terminus Drupal Console plugin to work, you must add Drupal Console to your Drupal site.  Drupal Console is already included if you are using the [Example Drops-8 Composer repository](https://github.com/pantheon-systems/example-drops-8-composer) (recommended).

## Examples
* `terminus drupal my-site.dev list`
* `terminus drupal my-site.dev theme:debug`

## Installation
For help installing, see [Terminus's Wiki](https://github.com/pantheon-systems/terminus/wiki/Plugins)

## Help
Run `terminus help drupal` for help.
