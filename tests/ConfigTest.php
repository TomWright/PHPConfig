<?php


use PHPUnit\Framework\TestCase;
use TomWright\PHPConfig\Config;

class ConfigTest extends TestCase
{

    public function testConfigSetAndGet()
    {
        $config = Config::getInstance();

        $config->setItem('environment', 'first_environment');
        $this->assertEquals($config->getItem('environment'), 'first_environment');

        $config->setItem('some.config.item', 'my_value');
        $this->assertEquals($config->getItem('some.config.item'), 'my_value');
    }

}