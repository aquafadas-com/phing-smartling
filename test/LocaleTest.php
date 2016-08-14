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
    $this->assertEquals(Locale::getSpecificLocale('en'), 'en-US');
    $this->assertEquals(Locale::getSpecificLocale('en-US'), 'en-US');

    $this->assertEquals(Locale::getSpecificLocale('fr'), 'fr-FR');
    $this->assertEquals(Locale::getSpecificLocale('fr-FR'), 'fr-FR');

    $this->assertEquals(Locale::getSpecificLocale('fooBar'), 'fooBar');
  }
}
