<?php

namespace Carboneum\CascadeConfig\Exception\FileSystem;

/**
 * Class FileNotFound
 * @package Carboneum\CascadeConfig
 */
class FileNotFound extends PathException
{
    const CODE = self::ERROR_CODE_FILE_NOT_FOUND;
    const MESSAGE = 'File {path} could not found or is unreadable';
}
