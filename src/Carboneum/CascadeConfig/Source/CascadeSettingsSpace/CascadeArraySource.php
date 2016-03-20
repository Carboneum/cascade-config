<?php

namespace Carboneum\CascadeConfig\Source\CascadeSettingsSpace;

use Carboneum\CascadeConfig\Interfaces\CascadeSourceInterface;
use Carboneum\CascadeConfig\Model\CascadeSettingsSpace;
use Carboneum\NestedState\State;

class CascadeArraySource implements CascadeSourceInterface
{
    /**
     * @var array
     */
    protected $configData;

    /**
     * @var State
     */
    protected $state;

    /**
     * @param array $configData
     */
    public function __construct(array $configData)
    {
        $this->configData = $configData;
        $this->state = new State([]); //@todo change to helper
    }

    /**
     * @inheritdoc
     */
    public function getSettingsSpace($name)
    {
        return new CascadeSettingsSpace($name, $this, $this->createChunks(array_keys($this->configData[$name])));
    }

    /**
     * @inheritdoc
     */
    public function getSettingsSpacesNames()
    {
        return array_keys($this->configData);
    }

    /**
     * @inheritdoc
     */
    public function getChunk($spaceName, $chunkName)
    {
        return $this->configData[$spaceName][$chunkName];
    }

    /**
     * @param array $chunkNames
     * @return array
     */
    protected function createChunks(array $chunkNames)
    {
        $chunks = [];
        foreach ($chunkNames as $name) {
            $chunks[$name] = $this->state->getParametersByString($name);
        };

        return $chunks;
    }
}
