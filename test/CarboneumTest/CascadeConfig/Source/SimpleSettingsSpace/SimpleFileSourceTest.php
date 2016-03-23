<?php

namespace CarboneumTest\CascadeConfig\Source\SimpleSettingsSpace;

use Carboneum\CascadeConfig\Interfaces\DirectoryFileReaderInterface;
use Carboneum\CascadeConfig\Model\SimpleSettingsSpace;
use Carboneum\CascadeConfig\Source\SimpleSettingsSpace\SimpleFileSource;
use Prophecy\Argument;

/**
 * Class SimpleFileSourceTest
 * @package CarboneumTest\CascadeConfig
 */
class SimpleFileSourceTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testGetSettingsSpacesNames()
    {
        $fileReaderMock = $this->prophesize(DirectoryFileReaderInterface::class);
        $fileReaderMock->getFileList()->willReturn(
            [
                'core/settings',
                'core/params',
                'modules/blog',
                'modules/admin',
            ]
        );

        $source = new SimpleFileSource($fileReaderMock->reveal());

        $this->assertEquals(
            [
                'core/settings',
                'core/params',
                'modules/blog',
                'modules/admin'
            ],
            $source->getSettingsSpacesNames()
        );
    }

    /**
     *
     */
    public function test()
    {
        $fileReaderMock = $this->prophesize(DirectoryFileReaderInterface::class);
        $fileReaderMock->readFile(Argument::any())->willReturn(['foo' => 'bar']);

        $source = new SimpleFileSource($fileReaderMock->reveal());

        $this->assertEquals(
            new SimpleSettingsSpace('test', ['foo' => 'bar']),
            $source->getSettingsSpace('test')
        );
    }
}
