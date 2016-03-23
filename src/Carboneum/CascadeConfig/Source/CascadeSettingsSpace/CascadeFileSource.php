<?php

namespace Carboneum\CascadeConfig\Source\CascadeSettingsSpace;

use Carboneum\CascadeConfig\Interfaces\CascadeSourceInterface;
use Carboneum\CascadeConfig\Interfaces\DirectoryFileReaderInterface;
use Carboneum\CascadeConfig\Model\CascadeSettingsSpace;
use Carboneum\CascadeConfig\Service\FileReader;
use Carboneum\NestedState\Helper\ParameterSerializer;

/**
 * Class CascadeFileSource
 * @package Carboneum\CascadeConfig
 */
class CascadeFileSource implements CascadeSourceInterface
{
    /**
     * @var DirectoryFileReaderInterface
     */
    protected $fileReader;

    /**
     * @var ParameterSerializer
     */
    protected $serializer;

    /**
     * @var bool
     */
    protected $isLoaded = false;

    /**
     * @var array
     */
    protected $chunksIndex = [];

    /**
     * @param DirectoryFileReaderInterface $fileReader
     */
    public function __construct(DirectoryFileReaderInterface $fileReader)
    {
        $this->fileReader = $fileReader;
        $this->serializer = new ParameterSerializer();
    }

    /**
     * @inheritdoc
     */
    public function getChunk($spaceName, $chunkName)
    {
        return $this->fileReader->readFile($spaceName . DIRECTORY_SEPARATOR . $chunkName);
    }

    /**
     * @inheritdoc
     */
    public function getSettingsSpace($name)
    {
        if (false === $this->isLoaded) {
            $this->loadChunks();
        }

        return new CascadeSettingsSpace($name, $this, $this->createChunks($this->chunksIndex[$name]));
    }

    /**
     * @inheritdoc
     */
    public function getSettingsSpacesNames()
    {
        if (false === $this->isLoaded) {
            $this->loadChunks();
        }

        return array_keys($this->chunksIndex);
    }

    /**
     *
     */
    protected function loadChunks()
    {
        foreach ($this->fileReader->getFileList() as $file) {
            $fileComponents = explode(DIRECTORY_SEPARATOR, $file);
            $basename = array_pop($fileComponents);
            $directory = implode(DIRECTORY_SEPARATOR, $fileComponents);

            if (!isset($this->chunksIndex[$directory])) {
                $this->chunksIndex[$directory] = [];
            }

            $this->chunksIndex[$directory][] = $basename;
        }

        $this->isLoaded = true;
    }

    /**
     * @param array $chunkNames
     * @return array
     */
    protected function createChunks(array $chunkNames)
    {
        $chunks = [];
        foreach ($chunkNames as $name) {
            $chunks[$name] = false === strpos($name, '=') ? [] : $this->serializer->getParametersByString($name);
        };

        return $chunks;
    }
}
