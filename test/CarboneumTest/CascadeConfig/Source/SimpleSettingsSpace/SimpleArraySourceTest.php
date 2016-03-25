<?php

namespace CarboneumTest\CascadeConfig\Source\SimpleSettingsSpace;

use Carboneum\CascadeConfig\Interfaces\SettingsSpaceInterface;
use Carboneum\CascadeConfig\Source\SimpleSettingsSpace\SimpleArraySource;

/**
 * Class SimpleArraySourceTest
 * @package CarboneumTest\CascadeConfig
 */
class SimpleArraySourceTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testGetSettingsSpacesNames()
    {
        $source = new SimpleArraySource(
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

    /**
     *
     */
    public function test()
    {
        $source = new SimpleArraySource(
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

        $this->assertEquals(['foo' => 10, 'bar' => 20], $source->getSettingsSpace('settings')->getAll());
        $this->assertEquals(['olo' => 'pish'], $source->getSettingsSpace('config')->getAll());

        $this->assertInstanceOf(SettingsSpaceInterface::class, $source->getSettingsSpace('settings'));
        $this->assertInstanceOf(SettingsSpaceInterface::class, $source->getSettingsSpace('config'));
    }
}
