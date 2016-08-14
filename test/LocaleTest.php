<?php
/**
 * Implementation of the `phing\smartling\test\LocaleTest` class.
 */
namespace phing\smartling\test;
use phing\smartling\Locale;

/**
 * Tests the features of the `phing\smartling\Locale` class.
 */
class LocaleTest extends \PHPUnit_Framework_TestCase {

  /**
   * Tests the `getLocales` method.
   */
  public function testGetLocales() {
    $locales = Locale::getLocales();

    $neutralLocales = array_keys($locales);
    $this->assertEquals(count($neutralLocales), count(array_filter($neutralLocales, function($locale) {
      return preg_match('/^[a-z]{2}$/', $locale);
    })));

    $specificLocales = array_values($locales);
    $this->assertEquals(count($specificLocales), count(array_filter($specificLocales, function($locale) {
      return preg_match('/^[a-z]{2}-[A-Z]{2}$/', $locale);
    })));
  }

  /**
   * Tests the `getSpecificLocale` method.
   */
  public function testGetSpecificLocale() {
    $this->assertEquals('fooBar', Locale::getSpecificLocale('fooBar'));

    $this->assertEquals('en-GB', Locale::getSpecificLocale('en-GB'));
    $this->assertEquals('fr-BE', Locale::getSpecificLocale('fr-BE'));

    $this->assertEquals('en-US', Locale::getSpecificLocale('en'));
    $this->assertEquals('fr-FR', Locale::getSpecificLocale('fr'));
  }
}
