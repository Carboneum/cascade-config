<?php

namespace Carboneum\CascadeConfig\Exception\SettingsSpace;

use Carboneum\CascadeConfig\Exception\CascadeConfigException;

/**
 * Class SpaceException
 * @package Carboneum\CascadeConfig
 */
class SpaceException extends CascadeConfigException
{
    const CODE = 100;
    const MESSAGE = 'Error with space %space_name%';

    const SPACE_NAME = '%space_name%';

    /**
     * @param string $spaceName
     * @param \Exception $previous
     */
    public function __construct($spaceName, \Exception $previous = null)
    {
        parent::__construct([self::SPACE_NAME => $spaceName], $previous);
    }
}
