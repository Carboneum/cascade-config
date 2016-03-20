<?php

namespace Carboneum\CascadeConfig\Source\SimpleSettingsSpace;

use Carboneum\CascadeConfig\Interfaces\SourceInterface;
use Carboneum\CascadeConfig\Model\SimpleSettingsSpace;

/**
 * Class SimpleSettingsSpaceArraySource
 * @package Carboneum\CascadeConfig
 */
class SimpleArraySource implements SourceInterface
{
    /**
     * @var array
     */
    protected $configData;

    /**
     * @param array $configData
     */
    public function __construct(array $configData)
    {
        $this->configData = $configData;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsSpace($name)
    {
        return new SimpleSettingsSpace($name, $this->configData[$name]);
    }

    /**
     * @inheritdoc
     */
    public function getSettingsSpacesNames()
    {
        return array_keys($this->configData);
    }
}
