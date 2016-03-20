<?php

namespace Carboneum\CascadeConfig\Exception\SettingsSpace\SettingsSpaceKey;

class SpaceKeyMissingException extends SpaceKeyException
{
    const CODE = 110;
    const MESSAGE = 'Key %s of space %s is not defined';
}
