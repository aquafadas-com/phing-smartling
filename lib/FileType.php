<?php
/**
 * Implementation of the `phing\smartling\FileType` enumeration.
 */
namespace phing\smartling;

/**
 * Defines the type of a file to be uploaded.
 */
final class FileType {
  use Enum;

  /**
   * @var string The file is an Android XML resource.
   */
  const ANDROID = 'android';

  /**
   * @var string The file is a CSV resource.
   */
  const CSV = 'csv';

  /**
   * @var string The file is a Gettext PO/POT resource.
   */
  const GETTEXT = 'gettext';

  /**
   * @var string The file is an HTML resource.
   */
  const HTML = 'html';

  /**
   * @var string The file is a InDesign Markup Language resource.
   */
  const INDESIGN = 'idml';

  /**
   * @var string The file is an iOS Strings resource.
   */
  const IOS_STRINGS = 'ios';

  /**
   * @var string The file is an iOS Strings Dictionary resource.
   */
  const IOS_STRINGS_DICT = 'stringsdict';

  /**
   * @var string The file is a Java Properties resource.
   */
  const JAVA_PROPERTIES = 'javaProperties';

  /**
   * @var string The file is a JSON resource.
   */
  const JSON = 'json';

  /**
   * @var string The file is a MadCap Lingo ZIP resource.
   */
  const MADCAP_LINGO = 'madcap';

  /**
   * @var string The file is an Office Open XML resource.
   */
  const OPEN_XML = 'docx';

  /**
   * @var string The file is a plain text resource.
   */
  const PLAIN_TEXT = 'plainText';

  /**
   * @var string The file is a QT Linguist resource.
   */
  const QT_LINGUIST = 'qt';

  /**
   * @var string The file is a Microsoft Resx resource.
   */
  const RESX = 'resx';

  /**
   * @var string The file is a XLIFF resource.
   */
  const XLIFF = 'xliff';

  /**
   * @var string The file is a custom XML resource.
   */
  const XML = 'xml';

  /**
   * @var string The file is a YAML resource.
   */
  const YAML = 'yaml';
}
