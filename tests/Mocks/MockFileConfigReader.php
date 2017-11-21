<?php


namespace TomWright\PHPConfig\Tests\Mocks;


use TomWright\PHPConfig\Config;
use TomWright\PHPConfig\ConfigReader;

class MockFileConfigReader implements ConfigReader
{

    /**
     * @var string
     */
    private $filePath;


    /**
     * MockFileConfigReader constructor.
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }


    /**
     * Process the reader, filling $config with the desired values.
     * @param Config $config
     * @return void
     */
    public function process(Config $config)
    {
        $data = require $this->filePath;
        $config->putAll($data);
    }
}