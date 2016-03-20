<?php

namespace Carboneum\CascadeConfig;

use Carboneum\CascadeConfig\Exception\ConfigurationException\InvalidSourceException;
use Carboneum\CascadeConfig\Exception\ConfigurationException\StateIsNotDefined;
use Carboneum\CascadeConfig\Exception\SettingsSpace\SpaceNotDefinedException;
use Carboneum\CascadeConfig\Model\ImmutableSettingsSpace;
use Carboneum\CascadeConfig\Interfaces\SettingsSpaceInterface;
use Carboneum\CascadeConfig\Interfaces\SourceInterface;
use Carboneum\CascadeConfig\Interfaces\StateDependantInterface;
use Carboneum\NestedState\Interfaces\ReadableStateInterface;

/**
 * Class ConfigurationService
 * @package Carboneum\CascadeConfig
 */
class ConfigurationService
{
    /**
     * @var ReadableStateInterface
     */
    protected $state;

    /**
     * @var SourceInterface[]
     */
    protected $sources = [];

    /**
     * @var array
     */
    protected $spacesToSourcesMap = [];

    /**
     * @var SettingsSpaceInterface[]
     */
    protected $settingsSpaces = [];

    /**
     * @var ImmutableSettingsSpace[]
     */
    protected $immutableSpaces = [];

    /**
     * @var StateDependantInterface[]
     */
    protected $stateDependant = [];

    /**
     * @param SourceInterface[] $sources
     */
    public function __construct(array $sources)
    {
        $this->sources = $sources;
        $this->indexSources($this->sources);
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
        if (!isset($this->spacesToSourcesMap[$name])) {
            throw new SpaceNotDefinedException($name);
        }

        if (!isset($this->settingsSpaces[$name])) { // not loaded
            $this->loadSettingsSpace($name);
        }

        return $this->immutableSpaces[$name];
    }

    /**
     * @param ReadableStateInterface $state
     *
     * @return $this
     */
    public function setState(ReadableStateInterface $state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return $this
     */
    public function triggerStateChange()
    {
        foreach ($this->stateDependant as $space) {
            $space->triggerStateChange();
        }

        return $this;
    }

    /**
     * @param array $sources
     * @throws InvalidSourceException
     */
    protected function indexSources(array $sources)
    {
        foreach ($sources as $key => $source) {
            if (!is_object($source) && !$source instanceof SourceInterface) {
                throw new InvalidSourceException();
            }

            $spaceNames = $source->getSettingsSpacesNames();
            $this->spacesToSourcesMap = array_merge(
                $this->spacesToSourcesMap,
                array_combine($spaceNames, array_fill(0, count($spaceNames), $key))
            );
        }
    }

    /**
     * @param string $name
     * @throws \Exception
     */
    protected function loadSettingsSpace($name)
    {
        $space = $this->sources[$this->spacesToSourcesMap[$name]]->getSettingsSpace($name);

        if ($space instanceof StateDependantInterface) {
            $space->setState($this->getState());
            $this->stateDependant[] = $space;
        }

        $this->settingsSpaces[$name] = $space;
        $this->immutableSpaces[$name] = new ImmutableSettingsSpace($space);
    }

    /**
     * @return ReadableStateInterface
     *
     * @throws StateIsNotDefined
     */
    protected function getState()
    {
        if (null === $this->state) {
            throw new StateIsNotDefined();
        }

        return $this->state;
    }
}
