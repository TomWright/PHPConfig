<?php

namespace TomWright\PHPConfig\Tests\ConfigReader;

use PHPUnit\Framework\TestCase;
use TomWright\PHPConfig\Config;
use TomWright\PHPConfig\ConfigReader\InvalidConfigFileException;
use TomWright\PHPConfig\ConfigReader\InvalidFilePathException;
use TomWright\PHPConfig\ConfigReader\PHP\PHPFileReader;

class PHPFileReaderTest extends TestCase
{


    public function testSingleConfigReader()
    {
        $config = new Config(
            [
                'readers' => [new PHPFileReader(__DIR__ . '/../resources/PHPFileReader_Valid_A.php')],
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
                'readers' => [new PHPFileReader(__DIR__ . '/../resources/PHPFileReader_Valid_B.php')],
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
                    new PHPFileReader(__DIR__ . '/../resources/PHPFileReader_Valid_A.php'),
                    new PHPFileReader(__DIR__ . '/../resources/PHPFileReader_Valid_B.php'),
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
                    new PHPFileReader(__DIR__ . '/../resources/PHPFileReader_Valid_A.php'),
                    new PHPFileReader(__DIR__ . '/../resources/PHPFileReader_Valid_B.php'),
                    new PHPFileReader(__DIR__ . '/../resources/PHPFileReader_Valid_C.php'),
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

    public function testMissingConfigFilePathIsHandled()
    {
        $this->expectException(InvalidFilePathException::class);
        new Config([
            'readers' => [
                new PHPFileReader(''),
            ],
        ]);
    }

    public function testInvalidMissingConfigFilePathIsHandled()
    {
        $this->expectException(InvalidFilePathException::class);
        new Config([
            'readers' => [
                new PHPFileReader(__DIR__ . '/../resources/PHPFileReader_NonExistent.php'),
            ],
        ]);
    }

    public function testInvalidConfigFileContentIsHandled()
    {
        $this->expectException(InvalidConfigFileException::class);
        new Config([
            'readers' => [
                new PHPFileReader(__DIR__ . '/../resources/PHPFileReader_Invalid_A.php'),
            ],
        ]);
    }

}