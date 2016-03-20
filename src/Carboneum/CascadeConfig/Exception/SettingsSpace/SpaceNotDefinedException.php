<?php

namespace Carboneum\CascadeConfig\Exception\SpaceException;

use Carboneum\CascadeConfig\Exception\SpaceException;

/**
 * Class SpaceNotDefinedException
 * @package Carboneum\CascadeConfig
 */
class SpaceNotDefinedException extends SpaceException
{
    const CODE = 101;
    const MESSAGE = 'Space %s is not defined';
}
