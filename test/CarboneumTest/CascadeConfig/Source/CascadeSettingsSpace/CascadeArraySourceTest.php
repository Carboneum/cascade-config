<?php

namespace CarboneumTest\CascadeConfig\Source\CascadeSettingsSpace;

use Carboneum\CascadeConfig\Source\CascadeSettingsSpace\CascadeArraySource;

class CascadeArraySourceTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testGetSettingsSpacesNames()
    {
        $source = new CascadeArraySource(
            [
                'settings' => [
                    'foo' => 10,
                    'bar' => 20
                ],
                'config' => [
                    'olo' => 'pish'
                ]

            ]
        );

        $this->assertEquals(['settings', 'config'], $source->getSettingsSpacesNames());
    }
}
