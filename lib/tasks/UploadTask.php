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
   * @var \PhingFile The path to the message source.
   */
  private $file;

  /**
   * @var string The file type.
   */
  private $fileType = '';

  /**
   * @var UploadFileParameters The upload parameters.
   */
  private $params;

  /**
   * Initializes a new instance of the class.
   */
  public function __construct() {
    $this->params = new UploadFileParameters();
  }

  /**
   * Gets a value indicating whether content in the file is authorized (available for translation) in all locales.
   * @return bool `true` to authorize the file content in all locales, otherwise `false`.
   */
  public function getAuthorize(): bool {
    return $this->params->exportToArray()['authorize'] ?? false;
  }

  /**
   * Gets the URL of the callback called when the file is 100% published for a locale.
   * @return string The callback URL.
   */
  public function getCallbackUrl(): string {
    return $this->params->exportToArray()['callbackUrl'] ?? '';
  }

  /**
   * Gets the path to the message source.
   * @return \PhingFile The path to the message source.
   */
  public function getFile(): \PhingFile {
    return $this->file;
  }

  /**
   * Gets a value that uniquely identifies the file.
   * @return string The current file type.
   */
  public function getFileType(): string {
    return $this->fileType;
  }

  /**
   * Gets the list of specific locales in which the file content is authorized (available for translation).
   * @return array The list of authorized locales.
   */
  public function getLocalesToAuthorize(): array {
    return $this->params->exportToArray()['localeIdsToAuthorize[]'] ?? [];
  }

  /**
   * Initializes the instance.
   * @throws \BuildException The requirements are not met.
   */
  public function init() {
    parent::init();

    $fileType = $this->getFileType();
    if(mb_strlen($fileType) && !FileType::isDefined($fileType)) throw new \BuildException('File type not supported.');

    $file = $this->getFile();
    if(!$file || !is_file($file->getAbsolutePath())) throw new \BuildException('Unable to find the message source.');
  }

  /**
   * The task entry point.
   */
  public function main() {
    $fileType = $this->getFileType();
    $fileUri = $this->getFileUri();

    try {
      $this->createFileApi()->uploadFile(
        $this->getFile()->getAbsolutePath(),
        $fileUri,
        mb_strlen($fileType) ? $fileType : static::getFileTypeFromUri($fileUri),
        $this->params
      );
    }

    catch(SmartlingApiException $e) {
      throw new \BuildException($e);
    }
  }

  /**
   * Sets a value indicating whether content in the file is authorized (available for translation) in all locales.
   * @param bool $value `true` to authorize the file content in all locales, otherwise `false`.
   */
  public function setAuthorize(bool $value) {
    $this->params->setAuthorized($value);
  }

  /**
   * Sets the URL of the callback called when the file is 100% published for a locale.
   * @param string $value The new callback URL.
   */
  public function setCallbackUrl(string $value) {
    $this->params->setCallbackUrl($value);
  }

  /**
   * Sets the path to the message source.
   * @param \PhingFile $value The new path of the message source.
   */
  public function setFile(\PhingFile $value) {
    $this->file = $value;
  }

  /**
   * Sets a value that uniquely identifies the file.
   * @param string $value The new file type.
   */
  public function setFileType(string $value) {
    $this->fileType = $value;
  }

  /**
   * Sets the list of specific locales for which the file content is authorized (available for translation).
   * @param array $values The new list of authorized locales.
   */
  public function setLocalesToAuthorize(array $values) {
    $this->params->setLocalesToApprove($values);
  }
}
