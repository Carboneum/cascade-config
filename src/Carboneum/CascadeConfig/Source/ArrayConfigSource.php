<?php

namespace Carboneum\CascadeConfig\Source;

use Carboneum\CascadeConfig\Model\SettingsSpace;
use Carboneum\CascadeConfig\Model\SourceInterface;
use Carboneum\NestedState\State;

/**
 * Class FixtureConfigSource
 * @package Carboneum\CascadeConfig
 */
class ArrayConfigSource implements SourceInterface
{
    /**
     * @var array
     */
    protected $configData;

    /**
     * @param array $configData
     */
    public function __construct(array $configData)
    {
        $this->configData = $configData;
    }

    /**
     * @inheritdoc
     */
    public function getChunksForName($configName)
    {
        return $this->createChunksByName(array_keys($this->configData[$configName]));
    }

    /**
     * @inheritdoc
     */
    public function getChunk($configName, $chunkName)
    {
        return $this->configData[$configName][$chunkName];
    }

    /**
     * @inheritdoc
     */
    public function scanSettingsSpaces()
    {
        $result = [];
        foreach ($this->configData as $name => $chunks) {
            $result[] = new SettingsSpace($this, $name, $this->createChunksByName(array_keys($chunks)));
        }

        return $result;
    }

    /**
     * @param array $chunkNames
     * @return array
     * @internal param array $chunks
     */
    protected function createChunksByName(array $chunkNames)
    {
        $result = [];
        foreach ($chunkNames as $chunkName) {
            $result[$chunkName] = State::getParametersByString($chunkName);
        }

        return $result;
    }
}
