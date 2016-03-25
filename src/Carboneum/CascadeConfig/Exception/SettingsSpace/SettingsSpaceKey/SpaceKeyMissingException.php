<?php

namespace Carboneum\CascadeConfig\Exception\SettingsSpace\SettingsSpaceKey;

/**
 * Class SpaceKeyMissingException
 * @package Carboneum\CascadeConfig
 */
class SpaceKeyMissingException extends SpaceKeyException
{
    const CODE = self::ERROR_CODE_SPACE_KEY_MISSING;
    const MESSAGE = 'Key {key_name} of space {space_name} is not defined';
}
