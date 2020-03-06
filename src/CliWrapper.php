<?php

namespace Asilgag\CliWrapper;

use RuntimeException;

/**
 * A simple wrapper over CLI commands.
 */
class CliWrapper {

  /**
   * Array of bags to hold global CLI options that should be appended to all
   * commands.
   *
   * @var \Asilgag\CliWrapper\CliOptionsBag[]
   */
  protected $globalOptions = [];

  /**
   * CliWrapper constructor.
   */
  public function __construct() {
  }

  /**
   * Get global options bag.
   *
   * @param string $commandName
   *   Name of the command to which this global options will be applied.
   *
   * @return \Asilgag\CliWrapper\CliOptionsBag
   */
  public function getGlobalOptions(string $commandName): CliOptionsBag {
    if (!isset($this->globalOptions[$commandName])) {
      $this->globalOptions[$commandName] = new CliOptionsBag();
    }
    return $this->globalOptions[$commandName];
  }

  /**
   * Execute command on shell, using PHP exec() function.
   *
   * @param CliCommand $command
   *   Command to execute.
   * @param array $output
   *   [optional] Same as PHP exec() $output parameter.
   *   If the output argument is present, then the
   *   specified array will be filled with every line of output from the
   *   command. Trailing whitespace, such as \n, is not
   *   included in this array. Note that if the array already contains some
   *   elements, exec will append to the end of the array.
   *   If you do not want the function to append elements, call
   *   unset on the array before passing it to
   *   exec.
   * @param int $return_var
   *   [optional] Same as PHP exec() $return_var parameter.
   *   If the return_var argument is present
   *   along with the output argument, then the
   *   return status of the executed command will be written to this
   *   variable.
   *
   *  @see https://www.php.net/manual/en/function.exec
   */
  public function exec(CliCommand $command, array &$output = NULL, &$return_var = NULL): void {
    $commandString = $this->stringify($command);
    // Always add global options.
    $commandGlobalOptions = implode(' ', $this->getGlobalOptions($command->getCommand())->getBag());
    $commandString .= $commandGlobalOptions ? ' ' . $commandGlobalOptions : '';
    // Escape globs (*) to avoid them being executed when process is forked.
    $escapedCommandString = str_replace(['*', '\\*'], '\*', $commandString);
    exec($escapedCommandString, $output, $return_var);
    if ($return_var !== 0) {
      throw new RuntimeException('Error executing command ' . $commandString . ":\n" . implode("\n", $output));
    }
  }

  /**
   * Get a shell executable string from a command.
   *
   * This method must be overridden by other CLI wrappers to
   * denote each use case.
   *
   * @param CliCommand $command
   *   Command to execute.
   *
   * @return string
   *   A string that can be executed on a shell.
   */
  public function stringify(CliCommand $command): string {
    $commandParts[] = $command->getCommand();
    if (count($command->getOptions()) > 0) {
      $commandParts[] = implode(' ', $command->getOptions());
    }
    return implode(' ', $commandParts);
  }

  /**
   * Set environment variables for CLI.
   *
   * @param string $var
   *   Variable name.
   * @param string $value
   *   Variable value.
   */
  public function setEnvironment(string $var, string $value): void {
    putenv($var . '=' . $value);
  }

}
