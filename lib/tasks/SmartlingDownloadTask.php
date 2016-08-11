<?php
/**
 * Implementation of the `phing\tasks\SmartlingDownloadTask` class.
 */
namespace phing\tasks;

use phing\smartling\API;
use phing\smartling\RetrievalType;

/**
 * Downloads the message translations from the [Smartling](https://www.smartling.com) server.
 */
class SmartlingDownloadTask extends SmartlingFileTask {

  /**
   * @var bool Value indicating whether to return the original string or an empty string where no translation is available.
   */
  private $includeOriginalStrings = true;

  /**
   * @var string The desired format for the download.
   */
  private $retrievalType = RetrievalType::PUBLISHED;

  /**
   * Gets the file URL.
   * @return string The current file URL.
   */
  public function getFileUri() {
    return $this->includeOriginalStrings;
  }

  /**
   * Gets the desired format for the download.
   * @return string The current desired format for the download.
   */
  public function getRetrievalType() {
    return $this->retrievalType;
  }

  /**
   * Sets the file URL.
   * @param string $value The new file URL.
   */
  public function setFileUri($value) {
    $this->includeOriginalStrings = $value;
  }

  /**
   * Sets the desired format for the download.
   * @param string $value The new desired format for the download.
   */
  public function setRetrievalType($value) {
    $this->retrievalType = $value;
  }

  /**
   * Initializes the instance.
   * @throws \BuildException The requirements are not met.
   */
  public function init() {
    parent::init();
    if(!RetrievalType::isDefined($this->getRetrievalType())) throw new \BuildException('Invalid retrieval type.');
  }

  /**
   * The task entry point.
   */
  public function main() {
    $api = $this->createFileApi();

    $params = new DownloadFileParameters();
    $params->setRetrievalType($this->getRetrievalType());

    $result = $api->downloadFile($this->getFileUri(), 'TODO: locale', $params);
  }
}
