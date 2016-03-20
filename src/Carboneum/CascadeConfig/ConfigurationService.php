<?php

namespace Carboneum\CascadeConfig;

use Carboneum\CascadeConfig\Exception\ConfigurationException\InvalidSourceException;
use Carboneum\CascadeConfig\Exception\SettingsSpace\SpaceNotDefinedException;
use Carboneum\CascadeConfig\Interfaces\SettingsSpaceInterface;
use Carboneum\CascadeConfig\Interfaces\SourceInterface;
use Carboneum\CascadeConfig\Model\SettingsSpaceCollection;
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
     * @var SettingsSpaceCollection
     */
    protected $settingsSpaces;

    /**
     * @param SourceInterface[] $sources
     */
    public function __construct(array $sources)
    {
        $this->sources = $sources;
        $this->indexSources($this->sources);
        $this->settingsSpaces = new SettingsSpaceCollection();
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

        if (!$this->settingsSpaces->hasSettingSpace($name)) {
            $this->loadSettingsSpace($name);
        }

        return $this->settingsSpaces->getSettingsSpaceImmutable($name);
    }

    /**
     * @param ReadableStateInterface $state
     *
     * @return $this
     */
    public function setState(ReadableStateInterface $state)
    {
        $this->settingsSpaces->setState($state);

        return $this;
    }

    /**
     * @return $this
     */
    public function triggerStateChange()
    {
        $this->settingsSpaces->triggerStateChange();

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
        $this->settingsSpaces->addSettingsSpace(
            $this->sources[$this->spacesToSourcesMap[$name]]->getSettingsSpace($name)
        );
    }
}
