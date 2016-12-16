# Terminus Composer Plugin

[![Terminus v1.x Compatible](https://img.shields.io/badge/terminus-v1.x-green.svg)](https://github.com/pantheon-systems/terminus-composer-plugin/tree/1.x)
[![Terminus v0.x Compatible](https://img.shields.io/badge/terminus-v0.x-green.svg)](https://github.com/pantheon-systems/terminus-composer-plugin/tree/0.x)

Terminus Plugin to run [Composer](https://getcomposer.org/) commands on a [Pantheon](https://www.pantheon.io) sites.

Adds a command 'composer' to Terminus 1.x which you can use just like 'drush' or 'wp'. For a version that works with Terminus 0.x, see the [0.x branch](https://github.com/pantheon-systems/terminus-composer-plugin/tree/0.x).

This project is based on the `drush` and `wp` commands from Terminus core.

## Configuration

If using Composer to manage your site on Pantheon, it is best to start with the appropriate relocated document root Composer example project:

- WordPress: [Advanced WordPress on Pantheon](https://github.com/ataylorme/Advanced-WordPress-on-Pantheon)
- Drupal 8: [Example Drops-8 Composer](https://github.com/pantheon-systems/example-drops-8-composer)
- Drupal 7: tbd

Using Composer to manage standard sites on Pantheon not started with these upstreams (or a similar variant thereof) is not recommended.

## Examples
* `terminus composer my-site.dev -- composer config repositories.drupal composer https://packages.drupal.org/8`
* `terminus composer my-site.dev -- require drupal/media`
* `terminus composer my-site.dev -- update`

## Installation
For help installing, see [Terminus's Wiki](https://github.com/pantheon-systems/terminus/wiki/Plugins)
```
mkdir -p ~/.terminus/plugins
composer create-project -d ~/.terminus/plugins pantheon-systems/terminus-composer-plugin:~1
```
## Help
Run `terminus help composer` for help.
