<?php

namespace Carboneum\CascadeConfig\Source\CascadeSettingsSpace;

use Carboneum\CascadeConfig\Interfaces\CascadeSourceInterface;
use Carboneum\CascadeConfig\Model\CascadeSettingsSpace;
use Carboneum\NestedState\Helper\ParameterSerializer;

/**
 * Class CascadeArraySource
 * @package Carboneum\CascadeConfig
 */
class CascadeArraySource implements CascadeSourceInterface
{
    /**
     * @var array
     */
    protected $configData;

    /**
     * @var ParameterSerializer
     */
    protected $serializer;

    /**
     * @param array $configData
     */
    public function __construct(array $configData)
    {
        $this->configData = $configData;
        $this->serializer = new ParameterSerializer();
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
            $chunks[$name] = $this->serializer->getParametersByString($name);
        };

        return $chunks;
    }
}
