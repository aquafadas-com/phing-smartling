<?php
/**
 * Implementation of the `phing\tasks\SmartlingUploadTask` class.
 */
namespace phing\tasks;

/**
 * Uploads the message translations to the [Smartling](https://www.smartling.com) server.
 */
class SmartlingUploadTask extends SmartlingFileTask {

  /**
   * Initializes the instance.
   * @throws \BuildException The requirements are not met.
   */
  public function init() {
    if(!$this->checkRequirements()) throw new \BuildException('Your must provide the Smartling settings.');
  }

  /**
   * The task entry point.
   */
  public function main() {
    $api = $this->createFileApi();

    $params = new DownloadFileParameters();
    $params->setRetrievalType('TODO retrieval type');

    $result = $api->downloadFile($this->getFileUri(), 'TODO: locale', $params);
  }
}
