<?php

namespace Carboneum\CascadeConfig\Exception\SettingsSpaceKey;

use Carboneum\CascadeConfig\Exception\CascadeConfigException;

/**
 * Class SpaceKeyException
 * @package Carboneum\CascadeConfig
 */
abstract class SpaceKeyException extends CascadeConfigException
{
    const CODE = self::ERROR_CODE_SPACE_KEY_EXCEPTION;
    const MESSAGE = 'Error with key {key_name} of space {space_name}';

    const KEY_NAME = 'key_name';
    const SPACE_NAME = 'space_name';

    /**
     * @param string $keyName
     * @param string $spaceName
     * @param \Exception|null $previous
     */
    public function __construct($keyName, $spaceName, \Exception $previous = null)
    {
        $this->setContextValues([self::KEY_NAME => $keyName, self::SPACE_NAME => $spaceName]);
        parent::__construct($previous);
    }
}
