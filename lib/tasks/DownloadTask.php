<?php
/**
 * Implementation of the `phing\smartling\tasks\DownloadTask` class.
 */
namespace phing\smartling\tasks;

use phing\smartling\{Locale, RetrievalType};
use Smartling\Exceptions\SmartlingApiException;
use Smartling\File\Params\DownloadFileParameters;

/**
 * Downloads the message translations from the [Smartling](https://www.smartling.com) server.
 */
class DownloadTask extends FileTask {

  /**
   * @var string The pattern indicating the target path of the downloaded files.
   */
  private $filePattern = '';

  /**
   * @var array The locales to be downloaded.
   */
  private $locales = [];

  /**
   * @var DownloadFileParameters The download parameters.
   */
  private $params;

  /**
   * Initializes a new instance of the class.
   */
  public function __construct() {
    $this->params = new DownloadFileParameters();
  }

  /**
   * Gets the pattern indicating the target path of the downloaded files.
   * @return string The target path of the downloaded files (e.g. `"path/to/i18n/{{locale}}.json"`).
   */
  public function getFilePattern(): string {
    return $this->filePattern;
  }

  /**
   * Gets a value indicating whether to return the original string or an empty string when no translation is available.
   * @return bool `true` to return the original string when no translation is available, otherwise `false`.
   */
  public function getIncludeOriginalStrings(): bool {
    return $this->params->exportToArray()['includeOriginalStrings'] ?? false;
  }

  /**
   * Gets the list of locales to be downloaded.
   * @return array The locales to download.
   */
  public function getLocales(): array {
    return $this->locales;
  }

  /**
   * Gets the desired format for the download.
   * @return string The current desired format for the download.
   */
  public function getRetrievalType(): string {
    return $this->params->exportToArray()['retrievalType'] ?? RetrievalType::PUBLISHED;
  }

  /**
   * Initializes the instance.
   * @throws \BuildException The requirements are not met.
   */
  public function init() {
    parent::init();
    if(!mb_strlen($this->getFilePattern())) throw new \BuildException('You must provide the target path of the downloaded files.');
    if(!count($this->getLocales())) throw new \BuildException('You must provide at least one locale to download.');
  }

  /**
   * The task entry point.
   * @throws \BuildException An error occurred during the processing.
   */
  public function main() {
    $fileApi = $this->createFileApi();
    $filePattern = $this->getFilePattern();
    $fileUri = $this->getFileUri();

    try {
      foreach($this->getLocales() as $locale) {
        $path = str_replace('{{locale}}', $locale, $filePattern);
        if(!@file_put_contents($path, $fileApi->downloadFile($fileUri, Locale::getSpecificLocale($locale), $this->params)))
          throw new \BuildException("Unable to save the downloaded file: $path");
      }
    }

    catch(SmartlingApiException $e) {
      throw new \BuildException($e);
    }
  }

  /**
   * Sets the pattern indicating the target path of the downloaded files.
   * @param string $value The new target path of the downloaded files (e.g. `"path/to/i18n/{{locale}}.json"`).
   */
  public function setFilePattern(string $value) {
    $this->filePattern = $value;
  }

  /**
   * Sets a value indicating whether to return the original string or an empty string when no translation is available.
   * @param bool $value `true` to return the original string when no translation is available, otherwise `false`.
   */
  public function setIncludeOriginalStrings(bool $value) {
    $this->params->setIncludeOriginalStrings($value);
  }

  /**
   * Sets the list of locales to be downloaded.
   * @param array $value The locales to download.
   */
  public function setLocales(array $value) {
    $this->locales = $value;
  }

  /**
   * Sets the desired format for the download.
   * @param string $value The new desired format for the download.
   * @throws \BuildException The specified value is invalid.
   */
  public function setRetrievalType(string $value) {
    try { $this->params->setRetrievalType($value); }
    catch(SmartlingApiException $e) { throw new \BuildException($e); }
  }
}
