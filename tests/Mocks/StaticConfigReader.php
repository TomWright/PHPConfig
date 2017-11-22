<?php

namespace TomWright\PHPConfig\Tests\Mocks;


use TomWright\PHPConfig\Config;
use TomWright\PHPConfig\ConfigReader\ConfigReader;

class StaticConfigReader implements ConfigReader
{

    /**
     * Process the reader, filling $config with the desired values.
     * @param Config $config
     * @return void
     */
    public function process(Config $config)
    {
        $config->put('my-config-key', 'my-config-value');
    }

}