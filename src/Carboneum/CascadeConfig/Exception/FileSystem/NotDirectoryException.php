<?php

namespace Carboneum\CascadeConfig\Exception\FileSystem;

/**
 * Class NotDirectoryException
 * @package Carboneum\CascadeConfig
 */
class NotDirectoryException extends PathException
{
    const CODE = 302;
    const MESSAGE = 'File %path% is not a directory';
}
