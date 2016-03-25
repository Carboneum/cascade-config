<?php

namespace Carboneum\CascadeConfig\Exception\SettingsSpace;

/**
 * Class SpaceNotDefinedException
 * @package Carboneum\CascadeConfig
 */
class SpaceNotDefinedException extends SpaceException
{
    const CODE = self::ERROR_CODE_SPACE_NOT_DEFINED;
    const MESSAGE = 'Space {space_name} is not defined';
}
