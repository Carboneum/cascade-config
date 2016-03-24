<?php

namespace Carboneum\CascadeConfig\Exception;

/**
 * Class CascadeConfigException
 * @package Carboneum\CascadeConfig
 */
abstract class CascadeConfigException extends \Exception
{
    const CODE = 0;
    const MESSAGE = 'Error context: %error_context%';

    protected $context = [];

    /**
     * @param array $context
     * @param \Exception|null $previous
     */
    public function __construct(array $context = [], \Exception $previous = null)
    {
        parent::__construct($this->formatMessage(), static::CODE, $previous);
    }

    /**
     * @return string
     */
    protected function formatMessage()
    {
        return strtr(static::MESSAGE, array_merge($this->context, ['%error_context%' => json_encode($this->context)]));
    }
}
