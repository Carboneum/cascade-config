<?php

namespace Carboneum\CascadeConfig\Model;

/**
 * Interface SourceInterface
 * @package Carboneum\CascadeConfig
 */
interface SourceInterface
{
    /**
     * Returns list of state-dependant chunks for config locator name
     *
     * @param string $configName
     * @return array[string] Key in result array is chunk name;
     */
    public function getChunksForName($configName);

    /**
     * Returns list of config settings for chunk
     *
     * @param string $configName
     * @param string $chunkName
     * @return array
     */
    public function getChunk($configName, $chunkName);

    /**
     * Find defined configuration names in location
     *
     * @return ParametersSpaceInterface[] List of found spaces
     */
    public function scanConfigs();
}
