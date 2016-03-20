<?php

namespace Carboneum\CascadeConfig\Model;

use Carboneum\CascadeConfig\Carboneum\CascadeConfig\Interfaces\CascadeSourceInterface;
use Carboneum\CascadeConfig\Interfaces\SettingsSpaceInterface;
use Carboneum\CascadeConfig\Interfaces\StateDependantInterface;
use Carboneum\NestedState\Interfaces\ReadableStateInterface;

/**
 * Class CascadeSettingsSpace
 * @package Carboneum\CascadeConfig
 */
class CascadeSettingsSpace implements SettingsSpaceInterface, StateDependantInterface
{
    /**
     * @var CascadeSourceInterface
     */
    protected $source;

    /**
     * @var ReadableStateInterface
     */
    protected $state;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $compiledConfig = [];

    /**
     * @var bool
     */
    protected $isConfigCompiled = false;

    /**
     * @var array
     */
    protected $chunks;


    /**
     * @param string $name
     * @param CascadeSourceInterface $source
     * @param array $chunks
     */
    public function __construct($name, CascadeSourceInterface $source, $chunks)
    {
        $this->name = $name;
        $this->source = $source;
        $this->chunks = $chunks;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getAll()
    {
        if (false === $this->isConfigCompiled) {
            $this->compileConfig();
        }

        return $this->compiledConfig;
    }

    /**
     * @inheritdoc
     */
    public function get($key)
    {
        return $this->getAll()[$key];
    }

    /**
     * @inheritdoc
     */
    public function setState(ReadableStateInterface $state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function triggerStateChange()
    {
        $this->isConfigCompiled = false;

        return $this;
    }

    /**
     * Loads and compiles matching config chunks
     */
    private function compileConfig()
    {
        $matchedChunksNames = [];
        foreach ($this->chunks as $chunkName => $parameters) {
            if (false !== ($weight = $this->state->getMatchWeight($parameters))) {
                $matchedChunksNames[$chunkName] = $weight;
            }
        }

        asort($matchedChunksNames);

        $this->compiledConfig = [];
        foreach (array_keys($matchedChunksNames) as $chunkName) {
            $this->compiledConfig = array_merge(
                $this->compiledConfig,
                $this->source->getChunk($this->name, $chunkName)
            );
        }
    }
}
