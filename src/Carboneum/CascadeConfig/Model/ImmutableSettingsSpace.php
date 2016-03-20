<?php

namespace Carboneum\CascadeConfig\Model;

use Carboneum\CascadeConfig\Interfaces\SettingsSpaceInterface;

class ImmutableSettingsSpace implements SettingsSpaceInterface
{
    /**
     * @var SettingsSpaceInterface
     */
    protected $mutable;

    /**
     * @param SettingsSpaceInterface $mutable
     */
    public function __construct(SettingsSpaceInterface $mutable)
    {
        $this->mutable = $mutable;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->mutable->getAll();
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->mutable->get($key);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->mutable->getName();
    }
}
