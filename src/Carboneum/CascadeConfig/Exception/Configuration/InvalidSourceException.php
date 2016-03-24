<?php

namespace Carboneum\CascadeConfig\Exception\Configuration;

use Carboneum\CascadeConfig\Exception\CascadeConfigException;
use Carboneum\CascadeConfig\Interfaces\SourceInterface;

/**
 * Class InvalidSourceException
 * @package Carboneum\CascadeConfig
 */
class InvalidSourceException extends CascadeConfigException
{
    const CODE = 201;
    const MESSAGE = 'Configuration source must implement %interface_name%';

    const INTERFACE_NAME = '%interface_name%';

    /**
     * @param \Exception|null $previous
     */
    public function __construct(\Exception $previous = null)
    {
        $this->setContextValue(self::INTERFACE_NAME, SourceInterface::class);
        parent::__construct($previous);
    }
}
