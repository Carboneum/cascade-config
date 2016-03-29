<?php

namespace Carboneum\CascadeConfig\Exception\Configuration;

use Carboneum\CascadeConfig\Exception\CascadeConfigException;

/**
 * Class StateIsNotDefined
 * @package Carboneum\CascadeConfig
 */
class StateIsNotDefined extends CascadeConfigException
{
    const CODE = self::ERROR_CODE_STATE_IS_NOT_DEFINED;
    const MESSAGE = 'Trying to access state when it is not defined';
}
