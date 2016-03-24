<?php

namespace Carboneum\CascadeConfig\Exception\FileSystem;

use Carboneum\CascadeConfig\Exception\CascadeConfigException;

class PathException extends CascadeConfigException
{
    const CODE = 300;
    const MESSAGE = 'Error with file %path%';

    const FILE_PATH = '%path%';

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
