<?php

namespace Carboneum\CascadeConfig\Service;

use Carboneum\CascadeConfig\Exception\FileSystem\FileNotFound;
use Carboneum\CascadeConfig\Exception\FileSystem\NotDirectoryException;
use Carboneum\CascadeConfig\Interfaces\DirectoryFileReaderInterface;

/**
 * Class DirectoryFileReader
 * @package Carboneum\CascadeConfig
 */
abstract class FileReader implements DirectoryFileReaderInterface
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $extension = '';

    /**
     * @var int
     */
    protected $extensionLength = 0;

    /**
     * @param string $path
     * @param string $extension
     */
    public function __construct($path, $extension = '')
    {
        $this->path = $path;
        $this->extension = $extension;
        $this->extensionLength = strlen($extension);
    }

    /**
     *
     */
    public function getFileList()
    {
        if (!file_exists($this->path) || !is_readable($this->path)) {
            throw new FileNotFound($this->path);
        }

        if (!is_dir($this->path)) {
            throw new NotDirectoryException($this->path);
        }

        $result = [];

        $directories = [DIRECTORY_SEPARATOR];
        $directoriesCount = 1;
        for ($i = 0; $i < $directoriesCount; $i++) {
            $currentDirectory = $directories[$i];
            $fullCurrentDirectory = $this->path . $currentDirectory;

            if (!file_exists($fullCurrentDirectory) || !is_readable($fullCurrentDirectory)) {
                throw new FileNotFound($fullCurrentDirectory);
            }

            $files = scandir($fullCurrentDirectory);
            foreach ($files as $file) {
                if ('.' === $file || '..' === $file) {
                    continue;
                }

                if (is_dir($fullCurrentDirectory . $file)) {
                    $directories[] = $currentDirectory . $file . DIRECTORY_SEPARATOR;
                    $directoriesCount++;
                } elseif (0 === $this->extensionLength || substr($file, -$this->extensionLength) === $this->extension) {
                    $result[] = substr($currentDirectory, 1) . substr($file, 0, -$this->extensionLength);
                }
            }
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    abstract public function readFile($path);
}
