<?php

namespace Carboneum\CascadeConfig\Exception\Configuration;

use Carboneum\CascadeConfig\Exception\CascadeConfigException;

class StateIsNotDefined extends CascadeConfigException
{
    const CODE = 202;
    const MESSAGE = 'Trying to access state when it is not defined';
}
