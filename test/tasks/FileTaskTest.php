<?php
/**
 * Implementation of the `phing\smartling\test\tasks\FileTaskTest` class.
 */
namespace phing\smartling\test\tasks;

use phing\smartling\FileType;
use phing\smartling\tasks\FileTask;

/**
 * A sample file task.
 */
class SampleFileTask extends FileTask {

  /**
   * Returns the file type corresponding to the specified file URI.
   * @param string $fileUri The file URI.
   * @return string The file type corresponding to the specified file URI, or an empty string if the type is unknown.
   */
  public static function getFileTypeFromUri(string $fileUri): string {
    return parent::getFileTypeFromUri($fileUri);
  }
}

/**
 * Tests the features of the `phing\smartling\tasks\FileTask` class.
 */
class FileTaskTest extends \PHPUnit_Framework_TestCase {

  /**
   * Tests the `getFileTypeFromUri` method.
   */
  public function testGetFileTypeFromUri() {
    $this->assertEquals('', SampleFileTask::getFileTypeFromUri('/fooBar'));
    $this->assertEquals('', SampleFileTask::getFileTypeFromUri('/foo.bar'));

    $this->assertEquals(FileType::CSV, SampleFileTask::getFileTypeFromUri('/messages.csv'));
    $this->assertEquals(FileType::JSON, SampleFileTask::getFileTypeFromUri('/project/messages.json'));
    $this->assertEquals(FileType::JAVA_PROPERTIES, SampleFileTask::getFileTypeFromUri('messages.properties'));
    $this->assertEquals(FileType::XLIFF, SampleFileTask::getFileTypeFromUri('project/messages.xlf'));
  }

  /**
   * Tests the `main` method.
   */
  public function testMain() {
    $this->expectException(\BuildException::class);
    (new SampleFileTask())->main();
  }
}
