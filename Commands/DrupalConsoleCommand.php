<?php
namespace Terminus\Commands;

use Terminus\Collections\Sites;
use Terminus\Models\Environment;

/**
 * Run Drupal Console on Pantheon
 *
 * @command drupal
 */
class DrupalConsoleCommand extends CommandWithSSH {
  /**
   * {@inheritdoc}
   */
  protected $client = 'drupal';

  /**
   * {@inheritdoc}
   */
  protected $command = 'drupal';

  /**
   * Invoke Drupal Console commands on a Pantheon development site
   *
   * <commands>...
   * : The Drupal Console command you intend to run with its arguments, in quotes
   *
   * [--site=<site>]
   * : The name (DNS shortname) of your site on Pantheon
   *
   * [--env=<environment>]
   * : Your Pantheon environment. Default: dev
   *
   */
  public function __invoke($args, $assoc_args) {
    $sites = new Sites();
    $site  = $sites->get($this->input()->siteName(['args' => $assoc_args,]));
    $env_id = $this->input()->env(['args' => $assoc_args, 'site' => $site,]);
    /** @var Environment $environment */
    $environment = $site->environments->get($env_id);

    $command = 'composer drupal ' . implode(' ', $args);
    if ($result = $environment->sendCommandViaSsh($command)) {
      $output = $result['output'];
      if ($result['exit_code'] != 0) {
        $output = $result['exit_code'] . ': ' . $output;
        $this->log()->error($output);
      } else {
        $this->log()->info("\n" . $output);
      }
    } else {
      $output = 'Unable to execute command.';
      $this->log()->error($output);
    }
  }
}

