<?php
/**
 * Implementation of the `phing\tasks\SmartlingFileTask` class.
 */
namespace phing\tasks;

use phing\smartling\API;
use Smartling\File\FileApi;

/**
 * Downloads the message translations from the [Smartling](https://www.smartling.com) server.
 */
abstract class SmartlingFileTask extends \Task {
  use API;

  /**
   * @var string The file URL.
   */
  private $fileUri = '';

  /**
   * Gets the file URL.
   * @return string The current file URL.
   */
  public function getFileUri(): string {
    return $this->fileUri;
  }

  /**
   * Initializes the instance.
   * @throws \BuildException The requirements are not met.
   */
  public function init() {
    if(!$this->checkRequirements()) throw new \BuildException('Your must provide the Smartling settings.');
    if(!mb_strlen($this->getFileUri())) throw new \BuildException('Your must provide the URI of the message source.');
  }

  /**
   * Sets the file URL.
   * @param string $value The new file URL.
   */
  public function setFileUri(string $value) {
    $this->fileUri = $value;
  }

  /**
   * Creates a File API provider.
   * @return FileApi The newly created instance.
   */
  protected function createFileApi(): FileApi {
    return FileApi::create($this->createAuthProvider(), $this->getProjectId());
  }
}
