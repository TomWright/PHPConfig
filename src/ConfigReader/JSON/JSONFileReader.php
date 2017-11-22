<?php

namespace TomWright\PHPConfig\ConfigReader\JSON;


use TomWright\JSON\Exception\JSONDecodeException;
use TomWright\JSON\JSON;
use TomWright\PHPConfig\Config;
use TomWright\PHPConfig\ConfigReader\ConfigReader;
use TomWright\PHPConfig\ConfigReader\FileReader;
use TomWright\PHPConfig\ConfigReader\InvalidConfigFileException;

class JSONFileReader extends FileReader implements ConfigReader
{

    /**
     * @var JSON
     */
    private $jsonEncoder;

    /**
     * JSONFileReader constructor.
     * @param string $filePath
     */
    public function __construct($filePath)
    {
        parent::__construct($filePath);
        $this->jsonEncoder = new JSON();
    }

    /**
     * Process the reader, filling $config with the desired values.
     * @param Config $config
     * @return void
     * @throws InvalidConfigFileException
     */
    public function process(Config $config)
    {
        $this->verifyFilePath();
        $json = file_get_contents($this->getFilePath());

        try {
            $data = $this->jsonEncoder->decode($json, true);
        } catch (JSONDecodeException $e) {
            throw new InvalidConfigFileException("Invalid JSON in config file: {$this->getFilePath()}. {$e->getMessage()}");
        }

        $config->putAll($data);
    }

}