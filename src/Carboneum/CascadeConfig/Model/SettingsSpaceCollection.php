<?php

namespace Carboneum\CascadeConfig\Model;

use Carboneum\CascadeConfig\Exception\Configuration\StateIsNotDefined;
use Carboneum\CascadeConfig\Interfaces\SettingsSpaceInterface;
use Carboneum\CascadeConfig\Interfaces\StateDependantInterface;
use Carboneum\NestedState\Interfaces\ReadableStateInterface;

class SettingsSpaceCollection
{
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
     * @var ReadableStateInterface
     */
    protected $state;

    /**
     * @param SettingsSpaceInterface $settingsSpace
     */
    public function addSettingsSpace(SettingsSpaceInterface $settingsSpace)
    {
        if ($settingsSpace instanceof StateDependantInterface) {
            $settingsSpace->setState($this->getState());
            $this->stateDependant[] = $settingsSpace;
        }

        $this->settingsSpaces[$settingsSpace->getName()] = $settingsSpace;
        $this->immutableSpaces[$settingsSpace->getName()] = new ImmutableSettingsSpace($settingsSpace);
    }

    /**
     * @param ReadableStateInterface $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasSettingSpace($name)
    {
        return isset($this->settingsSpaces[$name]);
    }

    /**
     * @param string $name
     * @return ImmutableSettingsSpace
     */
    public function getSettingsSpaceImmutable($name)
    {
        return $this->immutableSpaces[$name];
    }

    /**
     *
     */
    public function triggerStateChange()
    {
        foreach ($this->stateDependant as $space) {
            $space->triggerStateChange();
        }
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
