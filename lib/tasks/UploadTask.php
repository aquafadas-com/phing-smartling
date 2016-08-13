<?php
/**
 * Implementation of the `phing\smartling\tasks\UploadTask` class.
 */
namespace phing\smartling\tasks;

use phing\smartling\FileType;
use Smartling\Exceptions\SmartlingApiException;
use Smartling\File\Params\UploadFileParameters;

/**
 * Uploads the message translations to the [Smartling](https://www.smartling.com) server.
 */
class UploadTask extends FileTask {

  /**
   * @var string The file type.
   */
  private $fileType = '';

  /**
   * @var UploadFileParameters The download parameters.
   */
  private $params;

  /**
   * @var string The path to the message source.
   */
  private $source;

  /**
   * Initializes a new instance of the class.
   */
  public function __construct() {
    $this->params = new UploadFileParameters();
    $this->setAuthorize(false);
  }

  /**
   * Gets a value indicating whether to return the original string or an empty string when no translation is available.
   * @return bool `true` to return the original string when no translation is available, otherwise `false`. Defaults to `false`.
   */
  public function getAuthorize(): bool {
    return $this->params->exportToArray()['authorize'];
  }

  /**
   * Gets a value that uniquely identifies the file.
   * @return string The current file type.
   */
  public function getFileType(): string {
    return $this->fileType;
  }

  /**
   * Gets the path to the message source.
   * @return string The path to the message source.
   */
  public function getSource(): string {
    return $this->source;
  }

  /**
   * Initializes the instance.
   * @throws \BuildException The requirements are not met.
   */
  public function init() {
    parent::init();
    if(!FileType::isDefined($this->getFileType())) throw new \BuildException('File type not supported.');
    if(!is_file($this->getSource())) throw new \BuildException('Unable to find the message source.');
  }

  /**
   * The task entry point.
   */
  public function main() {
    try {
      $this->createFileApi()->uploadFile(
        $this->getSource(),
        $this->getFileUri(),
        $this->getFileType(),
        $this->params
      );
    }

    catch(SmartlingApiException $e) {
      throw new \BuildException($e);
    }
  }

  /**
   * Sets a value indicating whether to return the original string or an empty string when no translation is available.
   * @param bool $value `true` to return the original string when no translation is available, otherwise `false`.
   */
  public function setAuthorize(bool $value) {
    $this->params->setAuthorized($value);
  }

  /**
   * Sets a value that uniquely identifies the file.
   * @param string $value The new file type.
   */
  public function setFileType(string $value) {
    $this->fileType = $value;
  }

  /**
   * Sets the path to the message source.
   * @param string $value The new path of the message source.
   */
  public function setSource(string $value) {
    $this->source = $value;
  }
}
