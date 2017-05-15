<?php
/**
 * Implementation of the `phing\smartling\RetrievalType` enumeration.
 */
namespace phing\smartling;
use Smartling\File\Params\DownloadFileParameters;

/**
 * Defines the retrieval type of a file to be downloaded.
 */
final class RetrievalType
{
  use Enum;
  /**
   * @var string Returns a modified version of the original file with strings wrapped in a specific set of Unicode symbols that can later be recognized and matched by the Chrome Context Capture Extension.
   */
  const CONTEXT_MATCHING_INSTRUMENTED = 'contextMatchingInstrumented';

  /**
   * @var string Returns any translations (including non-published translations).
   */
  const PENDING = DownloadFileParameters::RETRIEVAL_TYPE_PENDING;

  /**
   * @var string Returns a modified version of the original text with certain characters transformed and the text expanded.
   */
  const PSEUDO = DownloadFileParameters::RETRIEVAL_TYPE_PSEUDO;

  /**
   * @var string Returns only published/pre-published translations.
   */
  const PUBLISHED = DownloadFileParameters::RETRIEVAL_TYPE_PUBLISHED;
}
