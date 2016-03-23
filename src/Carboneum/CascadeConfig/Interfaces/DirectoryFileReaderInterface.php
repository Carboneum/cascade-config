<?php

namespace Carboneum\CascadeConfig\Interfaces;

use Carboneum\CascadeConfig\Exception\FileSystem\FileNotFound;
use Carboneum\CascadeConfig\Exception\FileSystem\NotDirectoryException;

/**
 * Interface DirectoryFileReaderInterface
 * @package Carboneum\CascadeConfig
 */
interface DirectoryFileReaderInterface
{
    /**
     * @return array
     *
     * @throws FileNotFound
     * @throws NotDirectoryException
     */
    public function getFileList();

    /**
     * @param string $path relative file path
     * @return array
     */
    public function readFile($path);
}
