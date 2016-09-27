<?php
/**
 * Implementation of the `phing\smartling\test\EnumTest` class.
 */
namespace phing\smartling\test;
use phing\smartling\{Enum};

/**
 * A sample enumeration.
 */
final class SampleEnum {
  use Enum;

  /**
   * @var bool The first enumerated value.
   */
  const ZERO = false;

  /**
   * @var int The second enumerated value.
   */
  const ONE = 1;

  /**
   * @var string The third enumerated value.
   */
  const TWO = 'two';

  /**
   * @var float The fourth enumerated value.
   */
  const THREE = 3.0;
}

/**
 * Tests the features of the `phing\smartling\Enum` class.
 */
class EnumTest extends \PHPUnit_Framework_TestCase {

  /**
   * Tests the constructor.
   */
  public function testConstructor() {
    $constructor = (new \ReflectionClass(SampleEnum::class))->getConstructor();
    $this->assertTrue($constructor->isFinal());
    $this->assertTrue($constructor->isPrivate());
  }

  /**
   * Tests the `isDefined` method.
   */
  public function testIsDefined() {
    $this->assertFalse(SampleEnum::isDefined(true));
    $this->assertFalse(SampleEnum::isDefined(1.0));
    $this->assertFalse(SampleEnum::isDefined('TWO'));
    $this->assertFalse(SampleEnum::isDefined(3));

    $this->assertTrue(SampleEnum::isDefined(false));
    $this->assertTrue(SampleEnum::isDefined(1));
    $this->assertTrue(SampleEnum::isDefined('two'));
    $this->assertTrue(SampleEnum::isDefined(3.0));
  }

  /**
   * Tests the `getConstants` method.
   */
  public function testGetConstants() {
    $this->assertEquals(['ZERO' => false, 'ONE' => 1, 'TWO' => 'two', 'THREE' => 3.0], SampleEnum::getConstants());
  }

  /**
   * Tests the `getName` method.
   */
  public function testGetName() {
    $this->assertEquals(SampleEnum::getName(true), '');
    $this->assertEquals(SampleEnum::getName(1.0), '');
    $this->assertEquals(SampleEnum::getName('TWO'), '');
    $this->assertEquals(SampleEnum::getName(3), '');

    $this->assertEquals(SampleEnum::getName(false), 'ZERO');
    $this->assertEquals(SampleEnum::getName(1), 'ONE');
    $this->assertEquals(SampleEnum::getName('two'), 'TWO');
    $this->assertEquals(SampleEnum::getName(3.0), 'THREE');
  }

  /**
   * Tests the `getNames` method.
   */
  public function testGetNames() {
    $this->assertEquals(['ZERO', 'ONE', 'TWO', 'THREE'], SampleEnum::getNames());
  }

  /**
   * Tests the `getValues` method.
   */
  public function testGetValues() {
    $this->assertEquals([false, 1, 'two', 3.0], SampleEnum::getValues());
  }
}
