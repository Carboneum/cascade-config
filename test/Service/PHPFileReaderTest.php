<?php

namespace CarboneumTest\CascadeConfig\Service;

use Carboneum\CascadeConfig\Service\PHPFileReader;

/**
 * Class PHPFileReaderTest
 * @package CarboneumTest\CascadeConfig
 * @todo check mikey179/vfsStream
 */
class PHPFileReaderTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     */
    public function testGetFileList()
    {
        $reader = new PHPFileReader($this->getTestFilesRoot() . 'simpleSettings');
        $this->assertEquals(['main', 'application/config'], $reader->getFileList());
    }

    /**
     *
     */
    public function testReadFile()
    {
        $reader = new PHPFileReader($this->getTestFilesRoot() . 'simpleSettings');

        $this->assertEquals(
            [
                'foo' => 10,
                'bar' => true
            ],
            $reader->readFile('application/config')
        );
    }

    /**
     * @param string $path
     *
     * @expectedException \Carboneum\CascadeConfig\Exception\FileSystem\FileNotFound
     *
     * @dataProvider provideTestGetListNotFoundException
     */
    public function testGetFileListNotFoundException($path)
    {
        $reader = new PHPFileReader($path);

        $reader->getFileList();
    }

    /**
     * @return array
     */
    public function provideTestGetListNotFoundException()
    {
        return [
            [$this->getTestFilesRoot() . 'notExists'],
            [$this->getTestFilesRoot() . 'notReadableInside']
        ];

    }

    /**
     * @expectedException \Carboneum\CascadeConfig\Exception\FileSystem\NotDirectoryException
     */
    public function testGetFileListNotDirectoryException()
    {
        $reader = new PHPFileReader($this->getTestFilesRoot() . 'simpleSettings/main.php');
        $reader->getFileList();
    }

    /**
     * @expectedException \Carboneum\CascadeConfig\Exception\FileSystem\FileNotFound
     */
    public function testReadFileNotFoundException()
    {
        $reader = new PHPFileReader($this->getTestFilesRoot() . 'simpleSettings');
        $reader->readFile('notExists');
    }

    /**
     * @return string
     */
    protected function getTestFilesRoot()
    {
        return __DIR__ . '/../../test-data/Service/PHPDirectoryFileReaderTest/';
    }
}
