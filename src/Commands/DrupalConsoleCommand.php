<?php
/**
 * Run Drupal Console on Pantheon
 */
namespace Pantheon\TerminusDrupalConsole\Commands;

use \Pantheon\Terminus\Commands\Remote\SSHBaseCommand;

/**
 * Say hello to the user
 */
class DrupalConsoleCommand extends SSHBaseCommand
{
    /**
     * @inheritdoc
     */
    protected $command = 'composer drupal';

    /**
     * @inheritdoc
     */
    protected $valid_frameworks = [
        'drupal8',
    ];

    /**
     * @inheritdoc
     */
    protected $unavailable_commands = [
    ];

    /**
     * Run an arbitrary Drupal Console command on a site's environment
     *
     * @authorize
     *
     * @command remote:drupal
     * @aliases drupal
     *
     * @param string $site_env_id Name of the environment to run the drush command on.
     * @param array $drupal_command Drush command to invoke on the environment
     * @return string Output of the given drush command executed on the site environment
     *
     * @usage terminus drupal <site>.<env> -- <command>
     *    Runs the Drupal Console command <command> on the <env> environment of <site>
     */
    public function drushCommand($site_env_id, array $drupal_command)
    {
        $this->prepareEnvironment($site_env_id);

        return $this->executeCommand($drupal_command);
    }
}
