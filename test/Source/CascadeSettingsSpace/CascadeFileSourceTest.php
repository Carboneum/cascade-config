<?php

namespace CarboneumTest\CascadeConfig\Source\CascadeSettingsSpace;

use Carboneum\CascadeConfig\Interfaces\DirectoryFileReaderInterface;
use Carboneum\CascadeConfig\Source\CascadeSettingsSpace\CascadeFileSource;
use Carboneum\NestedState\Interfaces\ReadableStateInterface;
use Carboneum\NestedState\State;
use Prophecy\Argument;

/**
 * Class CascadeFileSourceTest
 * @package CarboneumTest\CascadeConfig
 */
class CascadeFileSourceTest extends \PHPUnit_Framework_TestCase
{

    public function testGetSettingsSpacesNames()
    {
        $fileReaderMock = $this->prophesize(DirectoryFileReaderInterface::class);
        $fileReaderMock->getFileList()->willReturn(
            [
                'core/',
                'core/env=dev&lang=en',
                'core/env=prod',
                'modules/blog/env=prod',
                'modules/blog/user=0',
                'modules/admin/default',
                'modules/admin/lang=de',
            ]
        );

        $source = new CascadeFileSource($fileReaderMock->reveal());

        $this->assertEquals(['core', 'modules/blog', 'modules/admin'], $source->getSettingsSpacesNames());
    }

    /**
     * @param array $fileList
     * @param ReadableStateInterface $state
     * @param string $spaceName
     * @param array $expectedFilesRead
     *
     * @dataProvider provideTestGetSettingsSpace
     */
    public function testGetSettingsSpace(array $fileList, $state, $spaceName, $expectedFilesRead)
    {
        /** @var DirectoryFileReaderInterface $fileReaderMock */
        $fileReaderMock = $this->prophesize(DirectoryFileReaderInterface::class);
        $fileReaderMock->getFileList()->willReturn($fileList);

        foreach ($expectedFilesRead as $file) {
            $fileReaderMock->readFile(Argument::exact($file))->shouldBeCalled()->willReturn([]);
        }

        $source = new CascadeFileSource($fileReaderMock->reveal());
        $source->getSettingsSpace($spaceName)->setState($state)->getAll();
    }

    /**
     * @return array
     */
    public function provideTestGetSettingsSpace()
    {
        return [
            [
                'fileList' => [
                    'core/',
                    'core/env=dev&lang=en',
                    'core/env=dev',
                    'core/env=prod',
                ],
                'state' => new State(['env' => 'dev', 'user' => 100, 'lang' => 'en']),
                'spaceName' => 'core',
                'expectedCalls' => [
                    'core/',
                    'core/env=dev',
                    'core/env=dev&lang=en',
                ],
                [
                    'fileList' => [
                        'modules/blog/env=prod',
                        'modules/blog/user=0',

                    ],
                    'state' => new State(['env' => 'dev']),
                    'spaceName' => 'modules/blog',
                    'expectedCalls' => [
                        'modules/blog/env=prod',
                    ],
                    [
                        'fileList' => [
                            'modules/admin/default',
                            'modules/admin/lang=de',
                        ],
                        'state' => new State(['env' => null]),
                        'spaceName' => 'modules/admin',
                        'expected' => [
                            'modules/admin/default',
                            'modules/admin/lang=de',
                        ],
                    ],
                ],
            ]
        ];
    }
}
