<?php

namespace Asilgag\CliWrapper;

/**
 * A command to be executed on CLI.
 */
class CliCommand {

  /**
   * Command name (find, ls, etc)
   *
   * @var string
   */
  protected $command;

  /**
   * Array of options for the command.
   *
   * @var array|null
   */
  protected $options;

  /**
   * AwsCliCommand constructor.
   *
   * @param string $command
   *   Command name (s3, efs, lambda, etc)
   * @param array|null $options
   *   Array of options for the command (i.e.- ['--recursive', '--include *']).
   */
  public function __construct(string $command, array $options = NULL) {
    $this->command = $command;
    $this->options = $options;
  }

  /**
   * Get command name.
   *
   * @return string
   */
  public function getCommand(): string {
    return $this->command;
  }

  /**
   * Get options array.
   *
   * @return array|null
   */
  public function getOptions(): ?array {
    return $this->options;
  }

}
