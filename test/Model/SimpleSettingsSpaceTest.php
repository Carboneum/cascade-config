<?php

namespace CarboneumTest\CascadeConfig\Model;

use Carboneum\CascadeConfig\Model\SimpleSettingsSpace;

/**
 * Class SimpleSettingsSpaceTest
 * @package CarboneumTest\CascadeConfig
 */
class SimpleSettingsSpaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testGetters()
    {
        $simpleConfig = new SimpleSettingsSpace('testName', ['foo' => 1, 'bar' => 2]);

        $this->assertEquals('testName', $simpleConfig->getName());
        $this->assertEquals('1', $simpleConfig->get('foo'));
        $this->assertEquals('2', $simpleConfig->get('bar'));
        $this->assertEquals(['foo' => 1, 'bar' => 2], $simpleConfig->getAll());
    }

    /**
     * @expectedException \Carboneum\CascadeConfig\Exception\SettingsSpace\SettingsSpaceKey\SpaceKeyMissingException
     */
    public function testException()
    {
        $simpleConfig = new SimpleSettingsSpace('testName', ['foo' => 1, 'bar' => 2]);
        $simpleConfig->get('baz');
    }
}
