<?php

namespace Carboneum\CascadeConfig\Exception;

/**
 * Class SpaceException
 * @package Carboneum\CascadeConfig
 */
class SpaceException extends CascadeConfigException
{
    const CODE = 100;
    const MESSAGE = 'Error with space %s';

    /**
     * @var string
     */
    protected $space;

    /**
     * @param string $space
     * @param \Exception $previous
     */
    public function __construct($space, \Exception $previous = null)
    {
        $this->space = $space;
        parent::__construct(sprintf(static::MESSAGE, $space), self::CODE, $previous);
    }
}
