<?php


namespace Carboneum\CascadeConfig\Exception\Configure;

use Exception;
use Carboneum\CascadeConfig\Exception\CascadeConfigException;

/**
 * Class FileMissingException
 * @package Carboneum\Exception\Configure
 */
class FileMissingException extends CascadeConfigException
{
    /** @var string */
    protected $filePath;

    /**
     * @param string $filePath
     * @param string $message
     * @param int $code
     * @param Exception $previous
     */
    public function __construct(
        $filePath,
        $message = "File %s does not exist or is unreadable",
        $code = 0,
        Exception $previous = null
    ) {
        $this->filePath = $filePath;
        return parent::__construct(sprintf($message, $filePath), $code, $previous);
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }
}
