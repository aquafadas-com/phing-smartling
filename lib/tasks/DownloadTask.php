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
    $params = $this->params->exportToArray();
    return isset($params['includeOriginalStrings']) ? $params['includeOriginalStrings'] == 'true' : false;
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
   */
  public function init() {
    parent::init();
    $this->params = new DownloadFileParameters();
  }

  /**
   * The task entry point.
   * @throws \BuildException The requirements are not met, or an error occurred during the processing.
   */
  public function main() {
    parent::main();

    $filePattern = $this->getFilePattern();
    if(!mb_strlen($filePattern)) throw new \BuildException('You must provide the "filePattern" attribute.');

    $locales = $this->getLocales();
    if(!count($locales)) throw new \BuildException('You must specify at least one locale in the "locales" attribute.');

    try {
      $fileApi = $this->createFileApi();
      $fileUri = $this->getFileUri();

      foreach($locales as $locale) {
        $path = str_replace('{{locale}}', $locale, $filePattern);

        $output = dirname($path);
        if(!is_dir($output) && !mkdir($output, 0755, true)) throw new \BuildException("Unable to create the output folder: $output");

        if(!file_put_contents($path, $fileApi->downloadFile($fileUri, Locale::getSpecificLocale($locale), $this->params)))
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
    $this->params->setIncludeOriginalStrings($value ? 'true' : 'false');
  }

  /**
   * Sets the list of locales to be downloaded.
   * @param string $values The locales to download.
   */
  public function setLocales(string $values) {
    $this->locales = array_filter(array_map('trim', explode(',', $values)), function($locale) {
      return mb_strlen($locale);
    });
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
