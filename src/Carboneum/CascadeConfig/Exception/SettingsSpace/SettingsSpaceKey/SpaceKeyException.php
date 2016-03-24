<?php

namespace Carboneum\CascadeConfig\Exception\SettingsSpace\SettingsSpaceKey;

use Carboneum\CascadeConfig\Exception\SettingsSpace\SpaceException;

/**
 * Class SpaceKeyException
 *
 * @package Carboneum\CascadeConfig
 */
class SpaceKeyException extends SpaceException
{
    const CODE = 110;
    const MESSAGE = 'Error with key %key_name% of space %space_name%';

    const KEY_NAME = '%key_name%';

    /**
     * @param string $keyName
     * @param string $spaceName
     * @param \Exception|null $previous
     */
    public function __construct($keyName, $spaceName, \Exception $previous = null)
    {
        $this->setContextValue(self::KEY_NAME, $keyName);
        parent::__construct($spaceName, $previous);
    }
}
