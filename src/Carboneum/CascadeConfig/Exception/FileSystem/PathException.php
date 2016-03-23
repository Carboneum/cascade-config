<?php

namespace Carboneum\CascadeConfig\Exception\FileSystem;

use Carboneum\CascadeConfig\Exception\CascadeConfigException;

class PathException extends CascadeConfigException
{
    const CODE = 300;
    const MESSAGE = 'Error with file %s';

    /**
     * @var string
     */
    protected $filePath;

    /**
     * @param string $filePath
     * @param \Exception $previous
     */
    public function __construct($filePath, \Exception $previous = null)
    {
        $this->filePath = $filePath;
        parent::__construct($this->formatMessage(), self::CODE, $previous);
    }

    /**
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * @return string
     */
    protected function formatMessage()
    {
        return sprintf(static::MESSAGE, $this->filePath);
    }

}
