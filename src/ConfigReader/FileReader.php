<?php

namespace TomWright\PHPConfig\ConfigReader;

abstract class FileReader
{

    /**
     * @var string
     */
    private $filePath;


    /**
     * FileReader constructor.
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->setFilePath($filePath);
    }


    /**
     * @throws InvalidFilePathException
     */
    protected function verifyFilePath()
    {
        if (strlen($this->filePath) === 0) {
            throw new InvalidFilePathException('Missing File Reader file path provided.');
        }
        if (!file_exists($this->filePath) || !is_file($this->filePath)) {
            throw new InvalidFilePathException('Invalid File Reader file path provided.');
        }
    }


    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }


    /**
     * @param string $filePath
     */
    public function setFilePath(string $filePath)
    {
        $this->filePath = $filePath;
    }

}