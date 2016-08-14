<?php
/**
 * Implementation of the `phing\smartling\Locale` class.
 */
namespace phing\smartling;

/**
 * Provides static methods for locales.
 */
class Locale {

  /**
   * @var array Provides the mapping between neutral locales and default specific locales.
   */
  private static $locales = [
    'de' => 'de-DE',
    'en' => 'en-US',
    'es' => 'es-ES',
    'fr' => 'fr-FR',
    'it' => 'it-IT',
    'nl' => 'nl-NL',
    'ja' => 'ja-JP',
    'pt' => 'pt-PT',
    'ru' => 'ru-RU',
    'sv' => 'sv-SE',
    'zh' => 'zh-CN'
  ];

  /**
   * Private constructor: prohibit the class instantiation.
   */
  private function __construct() {}

  /**
   * Returns an array providing the mapping between neutral locales and default specific locales.
   * @return array The mapping between neutral locales and default specific locales.
   */
  public static function getLocales(): array {
    return static::$locales;
  }

  /**
   * Returns the default specific locale corresponding to the specified neutral locale.
   * @param string $neutralLocale A neutral locale.
   * @return string The default specific locale corresponding to the specified neutral locale, or the neutral locale if no specific locale matches.
   */
  public static function getSpecificLocale(string $neutralLocale): string {
    return static::getLocales()[$neutralLocale] ?? $neutralLocale;
  }
}
