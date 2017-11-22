<?php


namespace TomWright\PHPConfig\Tests;


use PHPUnit\Framework\TestCase;
use TomWright\PHPConfig\Config;
use TomWright\PHPConfig\Tests\Mocks\StaticConfigReader;

class ConfigReaderTest extends TestCase
{

    public function testConfigReaderIsProcessed()
    {
        $config = new Config(
            [
                'readers' => [new StaticConfigReader()],
            ]
        );
        $this->assertEquals([
            'my-config-key' => 'my-config-value',
        ], $config->getAll());
    }

}
