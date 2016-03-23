<?php

namespace Carboneum\CascadeConfig\Exception\SettingsSpace;

use Carboneum\CascadeConfig\Exception\CascadeConfigException;

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
    protected $spaceName;

    /**
     * @param string $filePath
     * @param \Exception $previous
     */
    public function __construct($filePath, \Exception $previous = null)
    {
        $this->spaceName = $filePath;
        parent::__construct($this->formatMessage(), self::CODE, $previous);
    }

    /**
     * @return string
     */
    public function getSpaceName()
    {
        return $this->spaceName;
    }

    /**
     * @return string
     */
    protected function formatMessage()
    {
        return sprintf(static::MESSAGE, $this->spaceName);
    }
}
