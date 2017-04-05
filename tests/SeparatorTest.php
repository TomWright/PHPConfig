<?php


use PHPUnit\Framework\TestCase;
use TomWright\PHPConfig\Config;

class SeparatorTest extends TestCase
{

    public function testWithDotSeparator()
    {
        $config = Config::getInstance(rand());
        $config->setSeparator('.');

        $config->setItem('some.config.item', 'my_value');
        $this->assertEquals($config->getItem('some.config.item'), 'my_value');
    }

    public function testWithPipeSeparator()
    {
        $config = Config::getInstance(rand());
        $config->setSeparator('|');

        $config->setItem('some|config|item', 'my_value');
        $this->assertEquals($config->getItem('some|config|item'), 'my_value');
    }

}