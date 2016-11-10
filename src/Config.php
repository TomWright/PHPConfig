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
     * Config constructor.
     */
    public function __construct()
    {
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
    protected function stripMultipleDotsFromItem($item)
    {
        return preg_replace('/\.{2,}/', '', $item);
    }


    /**
     * @param string $item
     * @param mixed $value
     * @return $this
     */
    public function setItem($item, $value)
    {
        $item = $this->stripMultipleDotsFromItem($item);
        $splitItems = explode('.', $item);

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
        $item = $this->stripMultipleDotsFromItem($item);
        if ($items === null) {
            $items = $this->getItems();
        }
        $result = null;
        $dotPos = strpos($item, '.');

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

}