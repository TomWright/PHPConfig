<?php

namespace TomWright\PHPConfig\Tests\ConfigReader;


use PHPUnit\Framework\TestCase;
use TomWright\PHPConfig\Config;
use TomWright\PHPConfig\ConfigReader\InvalidConfigFileException;
use TomWright\PHPConfig\ConfigReader\InvalidFilePathException;
use TomWright\PHPConfig\ConfigReader\JSON\JSONFileReader;

class JSONFileReaderTest extends TestCase
{

    public function testSingleConfigReader()
    {
        $config = new Config(
            [
                'readers' => [new JSONFileReader(__DIR__ . '/../resources/JSONFileReader_Valid_A.json')],
            ]
        );
        $this->assertEquals([
            'contacts' => [
                [
                    'name' => 'Tom',
                ],
                [
                    'name' => 'Jim',
                ],
                [
                    'name' => 'Jess',
                ],
            ],
            'primaryContact' => 'Tom',
        ], $config->getAll());
    }

    public function testAccessingArrayElementByIndex()
    {
        $config = new Config(
            [
                'readers' => [new JSONFileReader(__DIR__ . '/../resources/JSONFileReader_Valid_A.json')],
            ]
        );
        $this->assertEquals('Tom', $config->get('contacts.0.name'));
    }

    public function testMissingConfigFilePathIsHandled()
    {
        $this->expectException(InvalidFilePathException::class);
        new Config([
            'readers' => [
                new JSONFileReader(''),
            ],
        ]);
    }

    public function testInvalidMissingConfigFilePathIsHandled()
    {
        $this->expectException(InvalidFilePathException::class);
        new Config([
            'readers' => [
                new JSONFileReader(__DIR__ . '/../resources/JSONFileReader_NonExistent.json'),
            ],
        ]);
    }

    public function testInvalidConfigFileContentIsHandled()
    {
        $this->expectException(InvalidConfigFileException::class);
        new Config([
            'readers' => [
                new JSONFileReader(__DIR__ . '/../resources/JSONFileReader_Invalid_A.json'),
            ],
        ]);
    }

}