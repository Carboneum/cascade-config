<?php

namespace Carboneum\CascadeConfig\Exception\FileSystem;

use Carboneum\CascadeConfig\Exception\CascadeConfigException;

abstract class PathException extends CascadeConfigException
{
    const CODE = self::ERROR_CODE_PATH_EXCEPTION;
    const MESSAGE = 'Error with file {path}';

    const FILE_PATH = 'path';

    /**
     * @param string $spaceName
     * @param \Exception $previous
     */
    public function __construct($spaceName, \Exception $previous = null)
    {
        $this->setContextValue(self::FILE_PATH, $spaceName);
        parent::__construct($previous);
    }
}
