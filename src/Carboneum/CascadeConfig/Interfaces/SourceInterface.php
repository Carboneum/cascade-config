<?php

namespace Carboneum\CascadeConfig\Interfaces;

use Carboneum\CascadeConfig\Exception\SettingsSpace\SpaceNotDefinedException;

/**
 * Interface SourceInterface
 * @package Carboneum\CascadeConfig
 */
interface SourceInterface
{
    /**
     * Returns settings space
     *
     * @param string $name
     *
     * @throws SpaceNotDefinedException
     *
     * @return SettingsSpaceInterface
     */
    public function getSettingsSpace($name);

    /**
     * Find defined configuration names
     *
     * @return string[] List of found spaces names
     */
    public function getSettingsSpacesNames();
}
