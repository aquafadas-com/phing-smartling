<?php
/**
 * Implementation of the `phing\smartling\tasks\FileTask` class.
 */
namespace phing\smartling\tasks;
use phing\smartling\{API, FileType};

/**
 * Provides the base implementation for file-based tasks.
 */
abstract class FileTask extends \Task {
  use API;

  /**
   * @var string The file URI.
   */
  private $fileURI = '';

  /**
   * Gets a value that uniquely identifies the file.
   * @return string The current file URI.
   */
  public function getFileURI(): string {
    return $this->fileURI;
  }

  /**
   * The task entry point.
   * @throws \BuildException The requirements are not met.
   */
  public function main() {
    if(!mb_strlen($this->getFileURI())) throw new \BuildException('Your must provide the "fileURI" attribute.');
    if(!mb_strlen($this->getProjectId())) throw new \BuildException('Your must provide the "projectId" attribute.');
    if(!mb_strlen($this->getUserId())) throw new \BuildException('Your must provide the "userId" attribute.');
    if(!mb_strlen($this->getUserSecret())) throw new \BuildException('Your must provide "userSecret" attribute.');
  }

  /**
   * Sets a value that uniquely identifies the file.
   * @param string $value The new file URI.
   */
  public function setFileURI(string $value) {
    $this->fileURI = $value;
  }

  /**
   * Returns the file type corresponding to the specified file URI.
   * @param string $fileURI The file URI.
   * @return string The file type corresponding to the specified file URI, or an empty string if the type is unknown.
   */
  protected static function getFileTypeFromURI(string $fileURI): string {
    $extension = mb_strtolower(pathinfo($fileURI, PATHINFO_EXTENSION));
    switch($extension) {
      case FileType::CSV:
      case FileType::HTML:
      case FileType::INDESIGN:
      case FileType::JSON:
      case FileType::OPEN_XML:
      case FileType::RESX:
      case FileType::YAML:
        return $extension;

      case 'properties':
        return FileType::JAVA_PROPERTIES;

      case 'ts':
        return FileType::QT_LINGUIST;

      case 'txt':
        return FileType::PLAIN_TEXT;

      case 'xlf':
        return FileType::XLIFF;

      case 'yml':
        return FileType::YAML;

      default:
        return '';
    }
  }
}
