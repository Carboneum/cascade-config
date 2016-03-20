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
     * @param string $name
     * @param array $settings
     */
    public function __construct($name, array $settings)
    {
        $this->name = $name;
        $this->settings = $settings;
    }

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
        return $this->name;
    }
}
