<?php

namespace Asilgag\CliWrapper;

/**
 * A bag for holding options for a CLI command.
 */
class CliOptionsBag {

  /**
   * Array of CLI options.
   *
   * @var array
   */
  protected $bag = [];

  /**
   * Adds an option.
   *
   * @param string $option
   *   Option with name, separator and value. i.e.- "--format=txt".
   */
  public function add(string $option): void {
    $this->bag[] = $option;
  }

  /**
   * Get the bag of options.
   *
   * @return array
   *   Bag of options
   */
  public function getBag(): array {
    return $this->bag;
  }

  /**
   * Empties the bag of options.
   */
  public function empty(): void {
    $this->bag = [];
  }

}
