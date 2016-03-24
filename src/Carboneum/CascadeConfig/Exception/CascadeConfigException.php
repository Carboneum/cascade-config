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

    private $context = [];

    /**
     *
     * @param \Exception|null $previous
     */
    public function __construct(\Exception $previous = null)
    {
        parent::__construct($this->formatMessage(), static::CODE, $previous);
    }

    /**
     * @param string $name
     * @param string $value
     */
    protected function setContextValue($name, $value)
    {
        $this->context[$name] = $value;
    }

    /**
     * @return string
     */
    protected function formatMessage()
    {
        return strtr(static::MESSAGE, array_merge($this->context, ['%error_context%' => json_encode($this->context)]));
    }
}
