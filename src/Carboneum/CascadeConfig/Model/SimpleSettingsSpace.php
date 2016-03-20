<?php

namespace Carboneum\CascadeConfig\Model;

use Carboneum\CascadeConfig\Exception\SettingsSpace\SettingsSpaceKey\SpaceKeyMissingException;
use Carboneum\CascadeConfig\Interfaces\SettingsSpaceInterface;

/**
 * Class SimpleSettingsSpace
 * @package Carboneum\CascadeConfig
 */
class SimpleSettingsSpace implements SettingsSpaceInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $settings = [];

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->settings;
    }

    /**
     * @param string $key
     *
     * @throws SpaceKeyMissingException
     *
     * @return mixed
     */
    public function get($key)
    {
        if (!isset($this->settings[$key])) {
            throw new SpaceKeyMissingException($key, $this->getName());
        }

        return $this->settings[$key];
    }

    /**
     * @return string
     */
    public function getName()
    {
        $this->name;
    }
}
