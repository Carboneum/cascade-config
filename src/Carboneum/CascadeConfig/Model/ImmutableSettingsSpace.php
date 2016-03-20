<?php

namespace Carboneum\CascadeConfig\Model;

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
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->mutable->get($name);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getName();
    }
}
