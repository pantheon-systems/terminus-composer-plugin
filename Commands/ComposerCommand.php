<?php
namespace Terminus\Commands;

use Terminus\Models\Collections\Sites;
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
  protected $command = 'drush status  > /dev/null && ../bin/php ../files/private/composer.phar';

  /**
   * {@inheritdoc}
   */
  protected $unavailable_commands = [
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
      if ($environment->info('connection_mode') != 'sftp') {
        $switched_to_sftp = TRUE;
        $this->log()->info('Switching environment to SFTP mode.');
        $environment->changeConnectionMode('sftp');
      }
    }

    $this->ensureComposer($environment);

    $elements = $this->getElements($args, $assoc_args);

    if ($this->log()->getOptions('logFormat') != 'normal') {
      $elements['command']   .= ' --pipe';
    }
    $elements['command'] .= '';
    $result = $this->sendCommand($elements);
    $this->output()->outputDump($result);

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
   * Ensure composer is available for this site.
   *
   * @param \Terminus\Models\Environment $environment
   */
  private function ensureComposer(Environment $environment) {
    $this->log()->info('Testing to see if composer is installed on your site.');
    $connection_info = $environment->connectionInfo();
    $sftpCommand = $connection_info['sftp_command'];
    $renamed_composer = FALSE;
    $current_timestamp = microtime(FALSE);

    // If the user already has composer.phar in this directory, temporarily rename it
    if (file_exists('composer.phar')) {
      rename('composer.phar', $current_timestamp . '-composer.phar');
      $renamed_composer = TRUE;
    }

    if (\Terminus\Utils\isWindows()) {
      // Windows gets upset when you try and echo strings...
      exec("(echo cd files && echo cd private && echo get composer.phar) | $sftpCommand", $fetch_output, $fetch_status);
    } else {
      exec("(echo 'cd files' && echo 'cd private' && echo 'get composer.phar') | $sftpCommand", $fetch_output, $fetch_status);
    }
    if (file_exists('composer.phar')) {
      unlink('composer.phar');
    } else {
      $this->log()->info('Installing composer on your Pantheon site.  Please wait...');
      $this->installComposer($sftpCommand);
      $this->log()->info('Successfully installed composer on your Pantheon site.');
    }

    if ($renamed_composer) {
      rename($current_timestamp . '-composer.phar', 'composer.phar');
    }
  }

  /**
   * Install Composer on a Pantheon site
   *
   * @param $sftpCommand
   */
  private function installComposer($sftpCommand) {
    $filename = 'composer.phar';
    $this->downloadComposer($filename);

    if (\Terminus\Utils\isWindows()) {
      // Windows gets upset when you try and echo strings...
      exec("(echo cd files && echo cd private && echo put $filename) | $sftpCommand", $fetch_output, $fetch_status);
    } else {
      exec("(echo 'cd files' && echo 'cd private' && echo 'put $filename') | $sftpCommand", $fetch_output, $fetch_status);
    }

    unlink($filename);
  }

  /**
   * Download Composer from the composer website
   *
   * @param $path
   */
  private function downloadComposer($path) {
    // Latest composer.phar
    $url = 'https://getcomposer.org/composer.phar';

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);

    // Temporarily save the file locally so we can upload it
    file_put_contents($path, $data);
  }

}
