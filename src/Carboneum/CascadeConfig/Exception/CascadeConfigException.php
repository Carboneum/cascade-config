<?php

namespace Carboneum\CascadeConfig\Exception;

use Carboneum\ContextualException\Exception;

/**
 * Class CascadeConfigException
 * @package Carboneum\CascadeConfig
 */
abstract class CascadeConfigException extends Exception
{
    const CODE_PACKAGE_PREFIX = 102000;
    const CODE = 0;

    const MESSAGE = 'CascadeConfig exception. Context: {exception_contexts}';

    const ERROR_CODE_INVALID_SOURCE = 1;
    const ERROR_CODE_STATE_IS_NOT_DEFINED = 2;

    const ERROR_CODE_PATH_EXCEPTION = 10;
    const ERROR_CODE_FILE_NOT_FOUND = 11;
    const ERROR_CODE_NOT_A_DIRECTORY = 12;

    const ERROR_CODE_SPACE_EXCEPTION = 20;
    const ERROR_CODE_SPACE_NOT_DEFINED = 21;

    const ERROR_CODE_SPACE_KEY_EXCEPTION = 30;
    const ERROR_CODE_SPACE_KEY_MISSING = 31;
}
