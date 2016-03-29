<?php

namespace Carboneum\CascadeConfig\Interfaces;

use Carboneum\NestedState\Interfaces\ReadableStateInterface;

/**
 * Interface StateDependantInterface
 * @package Carboneum\CascadeConfig
 */
interface StateDependantInterface
{
    /**
     * @param ReadableStateInterface $state
     * @return $this
     */
    public function setState(ReadableStateInterface $state);

    /**
     * @return $this
     */
    public function triggerStateChange();
}
