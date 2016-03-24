<?php

namespace Carboneum\CascadeConfig\Exception\FileSystem;

/**
 * Class FileNotFound
 * @package Carboneum\CascadeConfig
 */
class FileNotFound extends PathException
{
    const CODE = 301;
    const MESSAGE = 'File %path% could not found or is unreadable';
}
