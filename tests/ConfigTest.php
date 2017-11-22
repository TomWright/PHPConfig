<?php

namespace TomWright\PHPConfig\Tests;

use PHPUnit\Framework\TestCase;
use TomWright\PHPConfig\Config;

class ConfigTest extends TestCase
{

    public function testConfigSetAndGet()
    {
        $config = new Config();

        $config->put('environment', 'first_environment');
        $this->assertEquals($config->get('environment'), 'first_environment');

        $config->put('some.config.item', 'my_value');
        $this->assertEquals($config->get('some.config.item'), 'my_value');
    }

    public function testConfigPutAndGetWithObjects()
    {
        $config = new Config();

        $obj = new \stdClass();
        $obj->one = 'x';
        $obj->two = new \stdClass();
        $obj->two->a = 'b';

        $config->put('item', $obj);

        $this->assertEquals('x', $config->get('item.one'));
        $this->assertEquals('b', $config->get('item.two.a'));
    }

    public function testConfigSetAndGetWithMultipleSeparators()
    {
        $config = new Config();

        $config->put('some....config..item', 'my_value');
        $this->assertEquals($config->get('some..config.....item'), 'my_value');
    }

    public function testSettingSeparatorInOptions()
    {
        $config = new Config([
            'separator' => '|',
        ]);

        $this->assertEquals('|', $config->getSeparator());
    }

    public function testSettingStoreInOptions()
    {
        $config = new Config([
            'store' => [
                'item-1' => true,
            ],
        ]);

        $this->assertEquals([
            'item-1' => true,
        ], $config->getAll());

        $config->put('item-2', 'asd');
        $this->assertEquals([
            'item-1' => true,
            'item-2' => 'asd',
        ], $config->getAll());
    }

    public function testAddingMultipleValuesOnTopOfNonArrayValue()
    {
        $config = new Config();

        $config->put('some.users', 'Tom');
        $this->assertEquals([
            'some' => [
                'users' => 'Tom',
            ]
        ], $config->getAll());

        $config->put('some.users.Tom.email', 'contact@tomwright.me');
        $this->assertEquals([
            'some' => [
                'users' => [
                    'Tom' => [
                        'email' => 'contact@tomwright.me',
                    ],
                ],
            ]
        ], $config->getAll());
    }

}