<?php

namespace Carboneum\CascadeConfig\Domain;

use Carboneum\CascadeConfig\Model\ParametersSpaceInterface;
use Carboneum\CascadeConfig\Model\SourceInterface;

/**
 * Class ConfigurationService
 * @package Carboneum\CascadeConfig
 */
class ConfigurationService
{
    /**
     * @var SourceInterface[]
     */
    protected $sources;

    /**
     * @var ParametersSpaceInterface[]
     */
    protected $spaces;

    /**
     * ConfigurationService constructor.
     * @param SourceInterface[] $sources
     */
    public function __construct(array $sources)
    {
        $this->sources = $sources;
    }

    /**
     * @param string $name
     *
     * @return ParametersSpaceInterface
     */
    public function getParametersSpace($name)
    {
        return $this->spaces[$name];
    }

    /**
     * @return $this
     */
    public function scanConfigs()
    {
        foreach ($this->sources as $source) {
            /** @var ParametersSpaceInterface $space */
            foreach ($source->scanConfigs() as $space) {
                $this->spaces[$space->getName()] = $space;
            }
        }

        return $this;
    }
}
