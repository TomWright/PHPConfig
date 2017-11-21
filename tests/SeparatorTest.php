<?php

namespace TomWright\PHPConfig\Tests;

use PHPUnit\Framework\TestCase;
use TomWright\PHPConfig\Config;

class SeparatorTest extends TestCase
{

    public function testWithDotSeparator()
    {
        $config = new Config();
        $config->setSeparator('.');

        $config->put('some.config.item', 'my_value');
        $this->assertEquals($config->get('some.config.item'), 'my_value');
    }

    public function testWithPipeSeparator()
    {
        $config = new Config();
        $config->setSeparator('|');

        $config->put('some|config|item', 'my_value');
        $this->assertEquals($config->get('some|config|item'), 'my_value');
    }

}