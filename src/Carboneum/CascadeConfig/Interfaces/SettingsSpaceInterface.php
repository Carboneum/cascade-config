<?php

namespace Carboneum\CascadeConfig\Interfaces;

use Carboneum\CascadeConfig\Exception\SettingsSpace\SettingsSpaceKey\SpaceKeyException;

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
     * @param string $key
     *
     * @throws SpaceKeyException
     *
     * @return mixed
     */
    public function get($key);

    /**
     * @return string
     */
    public function getName();
}
