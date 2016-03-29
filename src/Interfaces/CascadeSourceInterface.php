<?php

namespace Carboneum\CascadeConfig\Interfaces;

/**
 * Interface CascadeSourceInterface
 * @package Carboneum\CascadeConfig
 */
interface CascadeSourceInterface extends SourceInterface
{
    /**
     * @param string $spaceName
     * @param string $chunkName
     *
     * @return array
     */
    public function getChunk($spaceName, $chunkName);
}
