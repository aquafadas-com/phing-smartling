<?php
/**
 * Implementation of the `phing\smartling\test\tasks\FileTaskTest` class.
 */
namespace phing\smartling\test\tasks;

use phing\smartling\{FileType};
use phing\smartling\tasks\{FileTask};

/**
 * A sample file task.
 */
class SampleFileTask extends FileTask {

  /**
   * Returns the file type corresponding to the specified file URI.
   * @param string $fileURI The file URI.
   * @return string The file type corresponding to the specified file URI, or an empty string if the type is unknown.
   */
  public static function getFileTypeFromURI(string $fileURI): string {
    return parent::getFileTypeFromURI($fileURI);
  }
}

/**
 * Tests the features of the `phing\smartling\tasks\FileTask` class.
 */
class FileTaskTest extends \PHPUnit_Framework_TestCase {

  /**
   * Tests the `getFileTypeFromURI` method.
   */
  public function testGetFileTypeFromURI() {
    $this->assertEquals('', SampleFileTask::getFileTypeFromURI('/fooBar'));
    $this->assertEquals('', SampleFileTask::getFileTypeFromURI('/foo.bar'));

    $this->assertEquals(FileType::CSV, SampleFileTask::getFileTypeFromURI('/messages.csv'));
    $this->assertEquals(FileType::JSON, SampleFileTask::getFileTypeFromURI('/project/messages.json'));
    $this->assertEquals(FileType::JAVA_PROPERTIES, SampleFileTask::getFileTypeFromURI('messages.properties'));
    $this->assertEquals(FileType::XLIFF, SampleFileTask::getFileTypeFromURI('project/messages.xlf'));
  }

  /**
   * Tests the `main` method.
   */
  public function testMain() {
    $this->expectException(\BuildException::class);
    (new SampleFileTask())->main();
  }
}
