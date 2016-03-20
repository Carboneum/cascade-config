<?php

namespace Carboneum\CascadeConfig\Domain;

use Carboneum\CascadeConfig\Exception\SpaceException\SpaceNotDefinedException;
use Carboneum\CascadeConfig\Model\ImmutableSettingsSpace;
use Carboneum\CascadeConfig\Model\SettingsSpaceInterface;
use Carboneum\CascadeConfig\Model\SourceInterface;
use Carboneum\CascadeConfig\Model\StateDependantInterface;
use Carboneum\NestedState\State;

/**
 * Class ConfigurationService
 * @package Carboneum\CascadeConfig
 */
class ConfigurationService
{
    /**
     * @var SourceInterface[]
     */
    protected $sources = [];

    /**
     * @var SettingsSpaceInterface[]
     */
    protected $settingsSpaces = [];

    /**
     * @var array
     */
    protected $immutableSettingsSpaces = [];

    /**
     * @param SourceInterface[] $sources
     */
    public function __construct(array $sources)
    {
        $this->sources = $sources;
    }

    /**
     * @param string $name
     *
     * @throws SpaceNotDefinedException
     *
     * @return SettingsSpaceInterface
     */
    public function getSettingsSpace($name)
    {
        if (!isset($this->settingsSpaces[$name])) {
            throw new SpaceNotDefinedException($name);
        }

        if (!isset($this->immutableSettingsSpaces[$name])) {
            $this->immutableSettingsSpaces[$name] = new ImmutableSettingsSpace($this->settingsSpaces[$name]);
        }

        return $this->immutableSettingsSpaces[$name];
    }

    /**
     * @return $this
     */
    public function scanConfigs()
    {
        foreach ($this->sources as $source) {
            foreach ($source->scanSettingsSpaces() as $space) {
                $this->settingsSpaces[$space->getName()] = $space;
            }
        }

        return $this;
    }

    /**
     * @param State $state
     *
     * @return $this
     */
    public function applyState(State $state)
    {
        foreach ($this->settingsSpaces as $space) {
            if ($space instanceof StateDependantInterface) {
                $space->applyState($state);
            }
        }

        return $this;
    }
}
