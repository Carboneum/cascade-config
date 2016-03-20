<?php

namespace Carboneum\CascadeConfig\Domain;

use Carboneum\CascadeConfig\Exception\SpaceException\SpaceNotDefinedException;
use Carboneum\CascadeConfig\Model\SettingsSpaceInterface;
use Carboneum\CascadeConfig\Model\SourceInterface;
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

        return $this->settingsSpaces[$name];
    }

    /**
     * @return $this
     */
    public function scanConfigs()
    {
        foreach ($this->sources as $source) {
            foreach ($source->scanConfigs() as $space) {
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
        foreach($this->settingsSpaces as $space) {
            $space->applyState($state);
        }

        return $this;
    }
}
