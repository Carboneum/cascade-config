<?php

namespace Carboneum\CascadeConfig\Exception\FileSystem;

/**
 * Class NotDirectoryException
 * @package Carboneum\CascadeConfig
 */
class NotDirectoryException extends PathException
{
    const CODE = self::ERROR_CODE_NOT_A_DIRECTORY;
    const MESSAGE = 'File {path} is not a directory';
}
