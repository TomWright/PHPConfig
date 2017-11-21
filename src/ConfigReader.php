<?php


namespace TomWright\PHPConfig;


interface ConfigReader
{

    /**
     * Process the reader, filling $config with the desired values.
     * @param Config $config
     * @return void
     */
    public function process(Config $config);

}