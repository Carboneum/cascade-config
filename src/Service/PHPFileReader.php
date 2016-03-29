<?php

namespace Carboneum\CascadeConfig\Service;

use Carboneum\CascadeConfig\Exception\FileSystem\FileNotFound;
use Carboneum\CascadeConfig\Interfaces\DirectoryFileReaderInterface;

/**
 * Class PHPDirectoryFileReader
 * @package Carboneum\CascadeConfig
 */
class PHPFileReader extends FileReader implements DirectoryFileReaderInterface
{
    /**
     * @param string $path
     */
    public function __construct($path)
    {
        parent::__construct($path, '.php');
    }

    /**
     * @inheritdoc
     */
    public function readFile($path)
    {
        $fullPath = $this->path . DIRECTORY_SEPARATOR . $path . $this->extension;

        if (!file_exists($fullPath) || !is_readable($fullPath)) {
            throw new FileNotFound($fullPath);
        }

        return require $fullPath;
    }
}
