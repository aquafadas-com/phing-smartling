<?php
/**
 * Implementation of the `phing\smartling\tasks\FileTask` class.
 */
namespace phing\smartling\tasks;
use phing\smartling\API;

/**
 * Provides the base implementation for file-based tasks.
 */
abstract class FileTask extends \Task {
  use API;

  /**
   * @var string The file URI.
   */
  private $fileUri = '';

  /**
   * Gets a value that uniquely identifies the file.
   * @return string The current file URI.
   */
  public function getFileUri(): string {
    return $this->fileUri;
  }

  /**
   * Initializes the instance.
   * @throws \BuildException The requirements are not met.
   */
  public function init() {
    if(!mb_strlen($this->getFileUri())) throw new \BuildException('Your must provide the value that uniquely identifies the file.');
    if(!mb_strlen($this->getProjectId())) throw new \BuildException('Your must provide the project identifier.');
    if(!mb_strlen($this->getUserId())) throw new \BuildException('Your must provide the user identifier.');
    if(!mb_strlen($this->getUserSecret())) throw new \BuildException('Your must provide the user secret.');
  }

  /**
   * Sets a value that uniquely identifies the file.
   * @param string $value The new file URI.
   */
  public function setFileUri(string $value) {
    $this->fileUri = $value;
  }
}
