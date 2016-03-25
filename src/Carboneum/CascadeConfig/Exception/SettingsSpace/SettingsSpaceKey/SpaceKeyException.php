<?php

namespace Carboneum\CascadeConfig\Exception\SettingsSpace\SettingsSpaceKey;

use Carboneum\CascadeConfig\Exception\SettingsSpace\SpaceException;

/**
 * Class SpaceKeyException
 *
 * @package Carboneum\CascadeConfig
 */
abstract class SpaceKeyException extends SpaceException
{
    const CODE = self::ERROR_CODE_SPACE_KEY_EXCEPTION;
    const MESSAGE = 'Error with key {key_name} of space {space_name}';

    const KEY_NAME = 'key_name';

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
