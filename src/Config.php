<?php


namespace TomWright\PHPConfig;


use TomWright\Singleton\SingletonTrait;

class Config
{

    use SingletonTrait;

    /**
     * @var array|object
     */
    protected $items;

    /**
     * @var string
     */
    protected $separator;


    /**
     * Config constructor.
     */
    public function __construct()
    {
        $this->setSeparator('.');
        $this->setItems(array());
    }


    /**
     * @return array|object
     */
    public function getItems()
    {
        return $this->items;
    }


    /**
     * @param array|object $items
     * @return $this
     */
    public function setItems($items)
    {
        $this->items = $items;
        return $this;
    }


    /**
     * @param string $item
     * @return string
     */
    protected function stripMultipleSeparatorsFromItem($item)
    {
        $separator = $this->getSeparator();
        $safeSeparator = preg_quote($separator);
        return preg_replace('/' . $safeSeparator . '{2,}/', $this->getSeparator(), $item);
    }


    /**
     * @param string $item
     * @param mixed $value
     * @return $this
     */
    public function setItem($item, $value)
    {
        $item = $this->stripMultipleSeparatorsFromItem($item);
        $splitItems = explode($this->getSeparator(), $item);

        $totalSplitItems = count($splitItems);

        $items =& $this->items;

        $currentLoop = 0;
        foreach ($splitItems as $splitItem) {
            $currentLoop++;
            $isLastItem = ($currentLoop == $totalSplitItems);
            $subItem = $this->extractItemFromItems($splitItem, $items);
            if ($subItem === null) {
                $items[$splitItem] = array();
            } elseif (! is_array($subItem) && ! is_object($subItem)) {
                $items[$splitItem] = array($subItem);
            }

            if ($isLastItem) {
                $items[$splitItem] = $value;
            } else {
                $items =& $items[$splitItem];
            }
        }

        return $this;
    }


    /**
     * @param string $item
     * @param mixed $default
     * @param array|object $items
     * @return mixed|null
     */
    public function getItem($item, $default = null, $items = null)
    {
        $item = $this->stripMultipleSeparatorsFromItem($item);
        if ($items === null) {
            $items = $this->getItems();
        }
        $result = null;
        $dotPos = strpos($item, $this->getSeparator());

        if ($dotPos === false) {
            $result = $this->extractItemFromItems($item, $items);
        } else {
            // Get the first item in the list.
            $firstItem = substr($item, 0, $dotPos);
            // Get the rest of the items in the list.
            $remainingItems = substr($item, $dotPos + 1);
            $newItems = $this->extractItemFromItems($firstItem, $items);
            $result = $this->getItem($remainingItems, $default, $newItems);
        }
        return $result;
    }


    /**
     * @param string $item
     * @param array|object $items
     * @return mixed|null
     */
    protected function extractItemFromItems($item, $items)
    {
        $result = null;
        if (is_object($items) && isset($items->{$item})) {
            $result = $items->{$item};
        } elseif (is_array($items) && array_key_exists($item, $items)) {
            $result = $items[$item];
        }
        return $result;
    }


    /**
     * @return string
     */
    public function getSeparator()
    {
        return $this->separator;
    }


    /**
     * @param string $separator
     * @return $this
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;
        return $this;
    }

}