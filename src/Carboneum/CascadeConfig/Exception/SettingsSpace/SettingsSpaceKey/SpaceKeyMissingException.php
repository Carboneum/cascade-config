<?php

namespace Carboneum\CascadeConfig\Exception\SettingsSpace\SettingsSpaceKey;

class SpaceKeyMissingException extends SpaceKeyException
{
    const CODE = 111;
    const MESSAGE = 'Key %key_name% of space %space_name% is not defined';
}
