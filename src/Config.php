<?php


namespace TomWright\PHPConfig;

use TomWright\PHPConfig\ConfigReader\ConfigReader;

class Config
{

    /**
     * @var array|object
     */
    protected $store;

    /**
     * @var string
     */
    protected $separator;


    /**
     * Config constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->setSeparator('.');
        $this->store = [];

        if (array_key_exists('separator', $options) && is_string($options['separator'])) {
            $this->setSeparator($options['separator']);
        }
        if (array_key_exists('store', $options) && is_array($options['store'])) {
            $this->store = $options['store'];
        }
        if (array_key_exists('readers', $options) && is_array($options['readers'])) {
            foreach ($options['readers'] as $reader) {
                $this->read($reader);
            }
        }
    }


    /**
     * Processes the specified ConfigReader.
     * @param ConfigReader $reader
     */
    public function read(ConfigReader $reader)
    {
        $reader->process($this);
    }


    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->store;
    }


    /**
     * @param string $key
     * @return string
     */
    private function stripMultipleSeparatorsFromKey(string $key): string
    {
        $separator = $this->getSeparator();
        $safeSeparator = preg_quote($separator);
        return preg_replace('/' . $safeSeparator . '{2,}/', $this->getSeparator(), $key);
    }


    /**
     * @param array $data
     * @return Config
     */
    public function putAll(array $data): Config
    {
        foreach ($data as $key => $value) {
            $this->put($key, $value);
        }
        return $this;
    }


    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function put(string $key, $value): Config
    {
        $key = $this->stripMultipleSeparatorsFromKey($key);
        $keys = explode($this->getSeparator(), $key);
        $totalKeys = count($keys);

        $store =& $this->store;

        $currentKeyIndex = 0;
        foreach ($keys as $currentKey) {
            $currentKeyIndex++;
            $subItem = $this->getFromStore($currentKey, $store, null);
            if ($subItem === null) {
                $store[$currentKey] = [];
            } elseif (! is_array($subItem) && ! is_object($subItem)) {
                $store[$currentKey] = [$subItem];
            }

            $isLastKey = ($currentKeyIndex == $totalKeys);
            if ($isLastKey) {
                $store[$currentKey] = $value;
            } else {
                $store =& $store[$currentKey];
            }
        }

        return $this;
    }


    /**
     * Returns whether or not the key contains the separator.
     * @param string $key
     * @return bool
     */
    private function keyContainsSeparator(string $key): bool
    {
        return strpos($key, $this->getSeparator()) !== false;
    }


    /**
     * Returns the part of the key before the first separator.
     * @param string $key
     * @return string
     */
    private function getFirstKeyFromKey(string $key): string
    {
        $key = $this->stripMultipleSeparatorsFromKey($key);
        $separatorPos = strpos($key, $this->getSeparator());
        if ($separatorPos === false) {
            return $key;
        }
        return substr($key, 0, $separatorPos);
    }


    /**
     * Returns the remaining part of the key after the first separator.
     * @param string $key
     * @return string
     */
    private function getSubsequentKeyFromKey(string $key): string
    {
        $key = $this->stripMultipleSeparatorsFromKey($key);
        $separatorPos = strpos($key, $this->getSeparator());
        if ($separatorPos === false) {
            return $key;
        }
        return substr($key, $separatorPos + 1);
    }


    /**
     * @param string $key
     * @param mixed $default
     * @param array|object $store
     * @return mixed|null
     */
    public function get(string $key, $default = null, $store = null)
    {
        if ($store === null) {
            $store = $this->getAll();
        }

        if (! $this->keyContainsSeparator($key)) {
            return $this->getFromStore($key, $store);
        }

        $firstKey = $this->getFirstKeyFromKey($key);

        return $this->get(
            $this->getSubsequentKeyFromKey($key),
            $default,
            $this->getFromStore($firstKey, $store)
        );
    }


    /**
     * @param string $key
     * @param array|object $store
     * @param null $default
     * @return mixed|null
     */
    private function getFromStore(string $key, $store, $default = null)
    {
        if (is_object($store) && isset($store->{$key})) {
            return $store->{$key};
        }
        if (is_array($store) && array_key_exists($key, $store)) {
            return $store[$key];
        }
        return $default;
    }


    /**
     * @return string
     */
    public function getSeparator(): string
    {
        return $this->separator;
    }


    /**
     * @param string $separator
     * @return $this
     */
    public function setSeparator(string $separator): Config
    {
        $this->separator = $separator;
        return $this;
    }

}