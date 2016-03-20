<?php

namespace Carboneum\CascadeConfig\Exception\SettingsSpace\SettingsSpaceKey;

use Carboneum\CascadeConfig\Exception\SpaceException;

class SpaceKeyException extends SpaceException
{
    const CODE = 110;
    const MESSAGE = 'Error with key %s of space %s';

    /**
     * @var  string
     */
    protected $keyName;

    /**
     * @param string $keyName
     * @param string $spaceName
     *
     * @param \Exception $previous
     */
    public function __construct($keyName, $spaceName, \Exception $previous = null)
    {
        $this->keyName = $keyName;
        parent::__construct($spaceName, $previous);
    }

    /**
     * @return string
     */
    public function getKeyName()
    {
        return $this->keyName;
    }

    /**
     * @return string
     */
    protected function formatMessage()
    {
        return sprintf(static::MESSAGE, $this->keyName, $this->spaceName);
    }
}
