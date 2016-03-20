<?php


namespace Carboneum\CascadeConfig\Configuration\Model;

use Carboneum\CascadeConfig\Interfaces\ConfigSourceInterface;
use Carboneum\CascadeConfig\Interfaces\ConfigurationBagInterface;
use Carboneum\NestedState\State;

class ConfigurationBagBag implements ConfigurationBagInterface
{
    /**
     * @var array
     */
    protected $compiledConfig = null;

    /**
     * @var ConfigSourceInterface
     */
    protected $source;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $location;

    /**
     * @var array|null
     */
    private $chunks;

    /**
     * @param ConfigSourceInterface $source
     * @param string $name
     * @param string $location
     * @param array|null $chunks
     */
    public function __construct(ConfigSourceInterface $source, $name, $location, $chunks = null)
    {
        $this->source = $source;
        $this->name = $name;
        $this->location = $location;
        $this->chunks = $chunks;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        if (null === $this->compiledConfig) {
            $this->loadConfig();
        }

        return $this->compiledConfig;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->compiledConfig[$name];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param State $state
     * @return $this
     */
    public function applyState(State $state)
    {
        //@todo rewrite this

        $preCompiled = [];
        $configChunks = $this->source->getChunksForName($this->name);

        foreach ($configChunks as $envExpression => $config) {
            $weight = $state->getMatchWeight(State::getParametersByString($envExpression));

            if ($weight === false) {
                continue;
            }

            if (!isset($preCompiled[$weight])) {
                $preCompiled[$weight] = $config;
            } else {
                $preCompiled[$weight] = $preCompiled[$weight] + $config;
            }
        }

        krsort($preCompiled);
        $this->compiledConfig = [];

        foreach ($preCompiled as $config) {
            $this->compiledConfig += $config;
        }

        return $this;
    }

    private function loadConfig()
    {
        foreach($this->getChunks() as $

    }
}
