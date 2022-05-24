# Terminus Composer Plugin

[![CircleCI](https://circleci.com/gh/pantheon-systems/terminus-composer-plugin.svg?style=shield)](https://circleci.com/gh/pantheon-systems/terminus-composer-plugin)
[![Actively Maintained](https://img.shields.io/badge/Pantheon-Actively_Maintained-yellow?logo=pantheon&color=FFDC28)](https://pantheon.io/docs/oss-support-levels#actively-maintained)


Terminus Plugin to run [Composer](https://getcomposer.org/) commands on [Pantheon](https://www.pantheon.io) sites.

Adds a command 'composer' to Terminus 1.x, 2.x or 3.x which you can use just like 'drush' or 'wp'.

This project is a simplified version of the original [Terminus Composer Plugin](https://github.com/rvtraveller/terminus-composer) by Brian Thompson.

## Configuration

This plugin should only be used with sites that are managed by Composer. The recommended upstreams are:

- [WordPress](https://github.com/pantheon-upstreams/wordpress-project)
- [Drupal 9](https://github.com/pantheon-upstreams/drupal-project)

This plugin may also be used with "Build Tools" and "No CI Workflow" sites that were started with one of the following template projects:

- WordPress: [Advanced WordPress on Pantheon](https://github.com/ataylorme/Advanced-WordPress-on-Pantheon)
- Drupal 8: [Example Drops-8 Composer](https://github.com/pantheon-systems/example-drops-8-composer)
- Drupal 7: [Example Drops-7 Composer](https://github.com/pantheon-systems/example-drops-7-composer)

Using Composer to manage standard sites on Pantheon not started with these upstreams (or a similar variant thereof) is not recommended. Using with Drupal 8.8 on the [drops-8](https://github.com/pantheon-systems/drops-8) will produce a working site, but will make future dashboard updates difficult. Using with sites based on the [Standard non-Composer Pantheon WordPress upstream](https://github.com/pantheon-systems/wordpress), or Drupal versions prior to 8.8 is likely to break the site.

## Examples

* `terminus composer my-script`
* `terminus composer my-site.dev -- config repositories.drupal composer https://packages.drupal.org/8`
* `terminus composer my-site.dev -- require drupal/media`
* `terminus composer my-site.dev -- update`

## Installation

### Installing via Terminus 3
`terminus self:plugin:install pantheon-systems/terminus-composer-plugin`

On older versions of Terminus:
```
mkdir -p ~/.terminus/plugins
composer create-project --no-dev -d ~/.terminus/plugins pantheon-systems/terminus-composer-plugin:~1
```

## Help
Run `terminus help composer` for help.
