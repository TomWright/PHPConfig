<?php


namespace TomWright\PHPConfig\Tests;


use PHPUnit\Framework\TestCase;
use TomWright\PHPConfig\Config;
use TomWright\PHPConfig\Tests\Mocks\MockFileConfigReader;

class ConfigReaderTest extends TestCase
{

    public function testSingleConfigReader()
    {
        $config = new Config(
            [
                'readers' => [new MockFileConfigReader(__DIR__ . '/resources/ConfigA.php')],
            ]
        );
        $this->assertEquals([
            'config' => [
                'a' => [
                    'name' => 'Tom',
                ],
            ],
        ], $config->getAll());


        $config = new Config(
            [
                'readers' => [new MockFileConfigReader(__DIR__ . '/resources/ConfigB.php')],
            ]
        );
        $this->assertEquals([
            'config' => [
                'b' => [
                    'name' => 'Jim',
                ],
            ],
        ], $config->getAll());
    }

    public function testMultipleConfigReaders()
    {
        $config = new Config(
            [
                'readers' => [
                    new MockFileConfigReader(__DIR__ . '/resources/ConfigA.php'),
                    new MockFileConfigReader(__DIR__ . '/resources/ConfigB.php'),
                ],
            ]
        );
        $this->assertEquals([
            'config' => [
                'a' => [
                    'name' => 'Tom',
                ],
                'b' => [
                    'name' => 'Jim',
                ],
            ],
        ], $config->getAll());
    }

    public function testMultipleOverlappingConfigReaders()
    {
        $config = new Config(
            [
                'readers' => [
                    new MockFileConfigReader(__DIR__ . '/resources/ConfigA.php'),
                    new MockFileConfigReader(__DIR__ . '/resources/ConfigB.php'),
                    new MockFileConfigReader(__DIR__ . '/resources/ConfigC.php'),
                ],
            ]
        );
        $this->assertEquals([
            'config' => [
                'a' => [
                    'name' => 'Amelia',
                ],
                'b' => [
                    'name' => 'Jess',
                ],
            ],
        ], $config->getAll());
    }

}