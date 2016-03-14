<?php


namespace Carboneum\CascadeConfig\Model;

use Carboneum\NestedState\State;

/**
 * Interface ParametersSpaceInterface
 * @package Carboneum\CascadeConfig
 */
interface ParametersSpaceInterface
{
    /**
     * @return array
     */
    public function getArray();

    /**
     * @param string $name
     * @return mixed
     */
    public function get($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param State $state
     * @return $this
     */
    public function applyState(State $state);
}
