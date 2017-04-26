<?php
/**
 * Implementation of the `phing\smartling\tasks\UploadTask` class.
 */

namespace phing\smartling\tasks;

use phing\smartling\FileType;
use Smartling\Exceptions\SmartlingApiException;
use Smartling\File\Params\UploadFileParameters;

/**
 * Uploads the message translations to the [Smartling](https://www.smartling.com) server.
 */
class UploadTask extends FileTask
{
    /**
     * @var \PhingFile The path to the message source.
     */
    private $file;

    /**
     * @var string The file type.
     */
    private $fileType = '';

    /**
     * @var UploadFileParameters The upload parameters.
     */
    private $params;

    /**
     * Gets a value indicating whether content in the file is authorized (available for translation) in all locales.
     * @return bool `true` to authorize the file content in all locales, otherwise `false`.
     */
    public function isAuthorized()
    {
        $params = $this->params->exportToArray();
        return isset($params[ 'authorize' ]) && $params[ 'authorize' ] == 'true';
    }

    /**
     * Gets the URL of the callback called when the file is 100% published for a locale.
     * @return string The callback URL.
     */
    public function getCallbackUrl()
    {
        $paramArray = $this->params->exportToArray();
        return isset($paramArray[ 'callbackUrl' ]) ? $paramArray[ 'callbackUrl' ] : '';
    }

    /**
     * Gets the path to the message source.
     * @return \PhingFile The path to the message source.
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Gets the file type.
     * @return string The current file type.
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * Initializes the instance.
     */
    public function init()
    {
        parent::init();
        $this->params = new UploadFileParameters();
    }

    /**
     * The task entry point.
     * @throws \BuildException The requirements are not met.
     */
    public function main()
    {
        parent::main();

        $file = $this->getFile();
        if (! $file) {
            throw new \BuildException('You must provide the "file" attribute.');
        }
        if (! $file->isFile()) {
            throw new \BuildException('Unable to find the message source specified by the "file" attribute.');
        }

        $fileType = $this->getFileType();
        $fileURI  = $this->getFileURI();
        if (! mb_strlen($fileType)) {
            $fileType = static::getFileTypeFromURI($fileURI);
        }
        if (! FileType::isDefined($fileType)) {
            throw new \BuildException('Invalid "fileType" attribute.');
        }

        try {
            $this->createFileAPI()->uploadFile($file->getAbsolutePath(), $fileURI, $fileType, $this->params);
        } catch (SmartlingApiException $e) {
            throw new \BuildException($e);
        }
    }

    /**
     * Sets a value indicating whether content in the file is authorized (available for translation) in all locales.
     * @param bool $value `true` to authorize the file content in all locales, otherwise `false`.
     */
    public function setAuthorize($value)
    {
        $this->params->setAuthorized($value ? 'true' : 'false');
    }

    /**
     * Sets the URL of the callback called when the file is 100% published for a locale.
     * @param string $value The new callback URL.
     */
    public function setCallbackUrl($value)
    {
        $this->params->setCallbackUrl($value);
    }

    /**
     * Sets the path to the message source.
     * @param \PhingFile $value The new path of the message source.
     */
    public function setFile(\PhingFile $value)
    {
        $this->file = $value;
    }

    /**
     * Sets the file type.
     * @param string $value The new file type.
     */
    public function setFileType($value)
    {
        $this->fileType = $value;
    }
}
