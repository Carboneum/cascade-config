<?php

namespace CarboneumTest\CascadeConfig\Model;

use Carboneum\CascadeConfig\Model\ImmutableSettingsSpace;
use Carboneum\CascadeConfig\Model\SimpleSettingsSpace;

/**
 * Class ImmutableSettingsSpaceTest
 * @package CarboneumTest\CascadeConfig
 */
class ImmutableSettingsSpaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testProxyCalls()
    {
        $simpleConfig = new SimpleSettingsSpace('testName', ['foo' => 1, 'bar' => 2]);
        $immutableSpace = new ImmutableSettingsSpace($simpleConfig);

        $this->assertEquals('testName', $immutableSpace->getName());
        $this->assertEquals('1', $immutableSpace->get('foo'));
        $this->assertEquals('2', $immutableSpace->get('bar'));
        $this->assertEquals(['foo' => 1, 'bar' => 2], $immutableSpace->getAll());
    }

}
