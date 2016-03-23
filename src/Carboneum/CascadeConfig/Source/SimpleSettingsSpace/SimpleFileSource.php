<?php

namespace Carboneum\CascadeConfig\Source\SimpleSettingsSpace;

use Carboneum\CascadeConfig\Interfaces\DirectoryFileReaderInterface;
use Carboneum\CascadeConfig\Interfaces\SourceInterface;
use Carboneum\CascadeConfig\Model\SimpleSettingsSpace;

/**
 * Class SimpleFileSource
 * @package Carboneum\CascadeConfig
 */
class SimpleFileSource implements SourceInterface
{
    /**
     * @var DirectoryFileReaderInterface
     */
    protected $fileReader;

    /**
     * @param DirectoryFileReaderInterface $fileReader
     */
    public function __construct(DirectoryFileReaderInterface $fileReader)
    {
        $this->fileReader = $fileReader;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsSpace($name)
    {
        return new SimpleSettingsSpace($name, $this->fileReader->readFile($name));
    }

    /**
     * @inheritdoc
     */
    public function getSettingsSpacesNames()
    {
        return $this->fileReader->getFileList();
    }
}
