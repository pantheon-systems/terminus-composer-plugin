<?php
namespace Terminus\Commands;

use Terminus\Collections\Sites;
use Terminus\Models\Environment;

/**
 * Run composer on Pantheon
 *
 * @command composer
 */
class ComposerCommand extends CommandWithSSH {
  /**
   * {@inheritdoc}
   */
  protected $client = 'Composer';

  /**
   * {@inheritdoc}
   */
  protected $command = 'composer';

  /**
   * {@inheritdoc}
   */
  protected $unavailable_commands = [
    // The global command would try to write to the home directory in
    // a single Pantheon container. That's a recipe for confusion
    // since that directory is outside of the version-controlled code.
    // Any changes made in the home directory of a given container would
    // not carry over to other containers and would be lost as the given
    // environment eventually changes containers.
    'global' => '',
  ];

  /**
   * Invoke `composer` commands on a Pantheon development site
   *
   * <commands>...
   * : The Composer command you intend to run with its arguments, in quotes
   *
   * [--site=<site>]
   * : The name (DNS shortname) of your site on Pantheon
   *
   * [--env=<environment>]
   * : Your Pantheon environment. Default: dev
   *
   */
  public function __invoke($args, $assoc_args) {
    parent::__invoke($args, $assoc_args);
    $command = $this->ssh_command;
    $result = $this->sendCommandViaUnbufferedSsh($this->environment, $command);
    exit($result['exit_code']);
  }

  /**
   * Sends a command to an environment via SSH. Do not capture output.
   */
  public function sendCommandViaUnbufferedSsh($environment, $command)
  {
    $sftp = $environment->sftpConnectionInfo();
    $ssh_command = vsprintf(
        'ssh -T %s@%s -p %s -o "AddressFamily inet" %s',
        [$sftp['username'], $sftp['host'], $sftp['port'], escapeshellarg($command),]
    );

    passthru($ssh_command, $exit_code);

    return $exit_code;
  }
}
