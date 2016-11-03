# Terminus Drupal Console

Terminus Plugin to run [Drupal Console](https://github.com/hechoendrupal/DrupalConsole) commands on a [Pantheon](https://www.pantheon.io) sites.

Adds a command 'drupal' to Terminus which you can use just like 'drush' or 'wp'.

This project is based on the [Terminus Composer](https://github.com/rvtraveller/terminus-composer) plugin.

## Configuration

In order for the Terminus Drupal Console plugin to work, you must configure your Drupal site.

* Add Drupal Console to your Drupal site via `composer require`
* Add a Drupal Console configuration file to console/config.yml

The config.yml file should contain (at a minimum):
```
application:
    options:
        root: web
```
## Examples
* `terminus drupal "list" --site=my-site --env=dev`
* `terminus drupal "theme:debug" --site=my-site --env=dev`

## Installation
For help installing, see [Terminus's Wiki](https://github.com/pantheon-systems/terminus/wiki/Plugins)

## Help
Run `terminus help drupal` for help.
