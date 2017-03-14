# Terminus Composer Plugin

[![Terminus v1.x Compatible](https://img.shields.io/badge/terminus-v1.x-green.svg)](https://github.com/pantheon-systems/terminus-composer-plugin/tree/1.x)
[![Terminus v0.x Compatible](https://img.shields.io/badge/terminus-v0.x-green.svg)](https://github.com/pantheon-systems/terminus-composer-plugin/tree/0.x)

Terminus Plugin to run [Composer](https://getcomposer.org/) commands on a [Pantheon](https://www.pantheon.io) sites.

Adds a command 'composer' to Terminus 1.x which you can use just like 'drush' or 'wp'. For a version that works with Terminus 0.x, see the [0.x branch](https://github.com/pantheon-systems/terminus-composer-plugin/tree/0.x).

This project is a simplified version of the original [Terminus Composer Plugin](https://github.com/rvtraveller/terminus-composer) by Brian Thompson, updated for Terminus 1.x.

## Configuration

If using Composer to manage your site on Pantheon, it is best to start with the appropriate relocated document root Composer example project:

- WordPress: [Advanced WordPress on Pantheon](https://github.com/ataylorme/Advanced-WordPress-on-Pantheon)
- Drupal 8: [Example Drops-8 Composer](https://github.com/pantheon-systems/example-drops-8-composer)
- Drupal 7: [Example Drops-7 Composer](https://github.com/pantheon-systems/example-drops-7-composer)

Using Composer to manage standard sites on Pantheon not started with these upstreams (or a similar variant thereof) is not recommended. Ensure that your site's pantheon.yml contains `web_docroot: true`. See [Serving Sites from the Web Subdirectory](https://pantheon.io/docs/nested-docroot/) for more information.

## Examples
* `terminus composer my-site.dev -- composer config repositories.drupal composer https://packages.drupal.org/8`
* `terminus composer my-site.dev -- require drupal/media`
* `terminus composer my-site.dev -- update`

## Testing
To run the tests locally, just run `composer test`.  The tests presume that Terminus 1.x is installed and available in your PATH as `terminus`.

### Seting up testing for your own Terminus plugin

If you'd like to copy the test scripts here for use with your own Terminus plugin, you will also need to set up a Pantheon site to operate on. In Circle CI, set up the following environment variables:

- TERMINUS_SITE: The name of the Pantheon site to run tests against
- TERMINUS_TOKEN: A Pantheon machine token

You will also need to create an ssh key pair, and add the private key to Circle CI (leave the host empty), and add the public key to your account on Pantheon.

## Installation
For help installing, see [Terminus's Wiki](https://github.com/pantheon-systems/terminus/wiki/Plugins)
```
mkdir -p ~/.terminus/plugins
composer create-project -d ~/.terminus/plugins pantheon-systems/terminus-composer-plugin:~1
```
## Help
Run `terminus help composer` for help.
