<?php

namespace Carboneum\CascadeConfig\Exception\ConfigurationException;

use Carboneum\CascadeConfig\Exception\CascadeConfigException;
use Carboneum\CascadeConfig\Interfaces\SourceInterface;

/**
 * Class InvalidSourceException
 * @package Carboneum\CascadeConfig
 */
class InvalidSourceException extends CascadeConfigException
{
    const CODE = 201;
    const MESSAGE = 'Configuration source must implement %';

    /**
     * @param \Exception|null $previous
     */
    public function __construct(\Exception $previous = null)
    {
        parent::__construct($this->formatMessage(), self::CODE, $previous);
    }

    /**
     * @return string
     */
    private function formatMessage()
    {
        return sprintf(self::MESSAGE, SourceInterface::class);
    }
}
