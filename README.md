# Composer

Terminus Plugin to run [Composer](https://getcomposer.org) commands on a [Pantheon](https://www.pantheon.io) sites.

Adds a command 'composer' to Terminus which you can use just like 'drush' or 'wp'.  The results from the composer command
are automatically committed to your git repo.

Note that you can only run composer on dev or multidev environments as composer will almost always need to write to the 
filesystem.

## Examples
* `terminus composer "help" --site=my-site --env=dev`
* `terminus composer "install" --site=my-site --env=dev`


## Installation
For help installing, see [Terminus's Wiki](https://github.com/pantheon-systems/terminus/wiki/Plugins)

## Help
Run `terminus help composer` for help.
