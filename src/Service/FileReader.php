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

            list($newFiles, $newDirectories) = $this->getFilesAndDirectories($currentDirectory);

            $result = array_merge($result, $newFiles);
            $directories = array_merge($directories, $newDirectories);
            $directoriesCount += count($newDirectories);
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    abstract public function readFile($path);

    /**
     * @param string $currentDirectory
     * @return array
     */
    protected function getFilesAndDirectories($currentDirectory)
    {
        $fullCurrentDirectory = $this->path . $currentDirectory;
        $directoryFiles = scandir($fullCurrentDirectory);
        $directories = [];
        $files = [];

        foreach ($directoryFiles as $file) {
            if ('.' === $file || '..' === $file) {
                continue;
            }

            if (is_dir($fullCurrentDirectory . $file)) {
                $directories[] = $currentDirectory . $file . DIRECTORY_SEPARATOR;
            } elseif (0 === $this->extensionLength || substr($file, -$this->extensionLength) === $this->extension) {
                $files[] = substr($currentDirectory, 1) . substr($file, 0, -$this->extensionLength);
            }
        }
        return [$files, $directories];
    }
}
