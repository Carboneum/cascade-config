<?php

namespace Carboneum\CascadeConfig\Source\SimpleSettingsSpace;

use Carboneum\CascadeConfig\Interfaces\SourceInterface;
use Carboneum\CascadeConfig\Service\FileReader;

/**
 * Class SimpleFileSource
 * @package Carboneum\CascadeConfig
 */
class SimpleFileSource implements SourceInterface
{
    /**
     * @var FileReader
     */
    protected $fileReader;

    /**
     * @param FileReader $fileReader
     */
    public function __construct(FileReader $fileReader)
    {
        $this->fileReader = $fileReader;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsSpace($name)
    {
        return $this->fileReader->readFile($name);
    }

    /**
     * @inheritdoc
     */
    public function getSettingsSpacesNames()
    {
        return $this->fileReader->getFileList();
    }
}
