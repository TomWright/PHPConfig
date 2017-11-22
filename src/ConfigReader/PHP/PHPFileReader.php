<?php


namespace TomWright\PHPConfig\ConfigReader\PHP;


use TomWright\PHPConfig\Config;
use TomWright\PHPConfig\ConfigReader\ConfigReader;
use TomWright\PHPConfig\ConfigReader\FileReader;
use TomWright\PHPConfig\ConfigReader\InvalidConfigFileException;

class PHPFileReader extends FileReader implements ConfigReader
{

    /**
     * Process the reader, filling $config with the desired values.
     * @param Config $config
     * @return void
     * @throws InvalidConfigFileException
     */
    public function process(Config $config)
    {
        $this->verifyFilePath();
        $data = require $this->getFilePath();
        if (! is_array($data)) {
            throw new InvalidConfigFileException('Invalid PHPFileReader file contents. Array type is required.');
        }
        $config->putAll($data);
    }

}