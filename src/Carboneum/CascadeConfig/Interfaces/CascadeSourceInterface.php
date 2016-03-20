<?php

namespace Carboneum\CascadeConfig\Carboneum\CascadeConfig\Interfaces;

use Carboneum\CascadeConfig\Interfaces\SourceInterface;

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
