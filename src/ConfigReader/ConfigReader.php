<?php


namespace TomWright\PHPConfig\ConfigReader;


use TomWright\PHPConfig\Config;

interface ConfigReader
{

    /**
     * Process the reader, filling $config with the desired values.
     * @param Config $config
     * @return void
     */
    public function process(Config $config);

}