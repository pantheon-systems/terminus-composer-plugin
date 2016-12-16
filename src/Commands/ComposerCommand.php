<?php
/**
 * Run Drupal Console on Pantheon
 */
namespace Pantheon\TerminusComposer\Commands;

use \Pantheon\Terminus\Commands\Remote\SSHBaseCommand;

/**
 * Run a Composer Command
 */
class ComposerCommand extends SSHBaseCommand
{
    /**
     * @inheritdoc
     */
    protected $command = 'composer';

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
     * @command remote:composer
     * @aliases composer
     *
     * @param string $site_env_id Name of the environment to run the drush command on.
     * @param array $composer_command Composer command to invoke on the environment
     * @return string Output of the given composer command executed on the site environment
     *
     * @usage terminus composer <site>.<env> -- <command>
     *    Runs the Composer command <command> on the <env> environment of <site>
     */
    public function composerCommand($site_env_id, array $composer_command)
    {
        $this->prepareEnvironment($site_env_id);

        return $this->executeCommand($composer_command);
    }

    /**
     * @inheritdoc
     */
    protected function validateFramework($framework)
    {
        // no-op
    }
}
