<?php

namespace Carboneum\CascadeConfig\Configuration\Model;

use Carboneum\CascadeConfig\Model\SettingsSpaceInterface;
use Carboneum\CascadeConfig\Model\SourceInterface;
use Carboneum\CascadeConfig\Model\StateDependantInterface;
use Carboneum\NestedState\Interfaces\ReadableStateInterface;

class SettingsSpace implements SettingsSpaceInterface, StateDependantInterface
{
    /**
     * @var SourceInterface
     */
    protected $source;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $compiledConfig = null;

    /**
     * @var ReadableStateInterface
     */
    protected $state;

    /**
     * @var array|null
     */
    protected $chunks;

    /**
     * @param SourceInterface $source
     * @param string $name
     * @param array|null $chunks
     */
    public function __construct(SourceInterface $source, $name, $chunks = null)
    {
        $this->source = $source;
        $this->name = $name;
        $this->chunks = $chunks;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        if (null === $this->compiledConfig) {
            $this->compileConfig();
        }

        return $this->compiledConfig;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->getAll()[$name];
    }

    /**
     * @param ReadableStateInterface $state
     *
     * @return $this
     */
    public function applyState(ReadableStateInterface $state)
    {
        $this->state = $state;
        $this->compiledConfig = null;
    }

    /**
     * Loads and compiles matching config chunks
     */
    private function compileConfig()
    {
        if (null === $this->chunks) {
            $this->chunks = $this->source->getChunksForName($this->name);
        }

        $matchedChunksNames = [];
        foreach ($this->chunks as $chunkName => $parameters) {
            if (false !== ($weight = $this->state->getMatchWeight($parameters))) {
                $matchedChunksNames[$chunkName] = $weight;
            }
        }

        $this->compiledConfig = [];
        asort($matchedChunksNames);

        foreach (array_keys($matchedChunksNames) as $chunkName) {
            $this->compiledConfig = array_merge($this->source->getChunk($this->name, $chunkName));
        }
    }
}
