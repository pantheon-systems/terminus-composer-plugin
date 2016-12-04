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
  protected $client = 'composer';

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
    $switched_to_sftp = FALSE;

    $sites = new Sites();
    $site  = $sites->get($this->input()->siteName(['args' => $assoc_args,]));
    $env_id = $this->input()->env(['args' => $assoc_args, 'site' => $site,]);
    /** @var Environment $environment */
    $environment = $site->environments->get($env_id);

    if (in_array($env_id, ['test', 'live',])) {
      $this->failure('Composer cannot be run on test or live environments as the code base is not writable.');
    } else {
      if ($environment->get('connection_mode') != 'sftp') {
        $switched_to_sftp = TRUE;
        $this->log()->info('Switching environment to SFTP mode.');
        $environment->changeConnectionMode('sftp');
      }
    }

    $command = 'composer ' . implode(' ', $args);
    if ($this->log()->getOptions('logFormat') != 'normal') {
      $command .= ' --pipe';
    }
    $exit_code = $this->sendCommandViaUnbufferedSsh($environment, $command);
    if ($exit_code) {
      $this->failure('Command failed with exit code ' . $exit_code);
    }

    $diff = $environment->diffstat();
    $count = count((array)$diff);
    if ($count > 0) {
      $environment->commitChanges('Composer changes made by the Terminus Composer plugin.');
    }
    if ($switched_to_sftp) {
      $this->log()->info('Switching environment back to Git mode.');
      $environment->changeConnectionMode('git');
    }
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
