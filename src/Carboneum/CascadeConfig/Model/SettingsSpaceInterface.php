<?php

namespace Carboneum\CascadeConfig\Model;

/**
 * Interface ParametersSpaceInterface
 * @package Carboneum\CascadeConfig
 */
interface SettingsSpaceInterface
{
    /**
     * @return array
     */
    public function getAll();

    /**
     * @param string $name
     * @return mixed
     */
    public function get($name);

    /**
     * @return string
     */
    public function getName();
}
