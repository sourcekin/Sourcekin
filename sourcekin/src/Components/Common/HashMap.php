<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 06.07.18.
 */

namespace Sourcekin\Components\Common;

use Traversable;


/**
 * Class HashMap
 */
class HashMap implements \IteratorAggregate, \Countable {



    /**
     * @var array
     */
    protected $elements = [];

    /**
     * HashMap constructor.
     *
     * @param array $elements
     */
    public function __construct(array $elements = []) {
        $this->elements = $elements;
    }

    /**
     * @param      $name
     *
     * @param null $default
     *
     * @return Param
     */
    public function get($name, $default = null) {
        return $this->has($name) ? $this->elements[$name] : $default;
    }

    /**
     * @param $name
     * @param $value
     *
     * @return HashMap
     */
    public function set($name, $value) {
        $this->elements[$name] = $value;
        return $this;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function has($name) {
        return array_key_exists($name, $this->elements);
    }

    /**
     * @param $name
     *
     * @return HashMap
     */
    public function remove($name) {
        if ($this->has($name)) {
            unset($this->elements[$name]);
        }
        return $this;
    }

    /**
     * @param $element
     *
     * @return $this
     */
    public function removeElement($element) {
        while( false !== ($key = array_search($element, $this->elements))){
            unset($this->elements[$key]);
        }
        return $this;
    }

    /**
     * @param callable $filter
     *
     * @return HashMap
     */
    public function filter(callable $filter) : HashMap {
        return new static(array_filter($this->elements, $filter));
    }

    public function map(callable $map) : HashMap {
        return new static(array_map($map, $this->elements));
    }

    /**
     * @param callable $sorter
     *
     * @return $this
     */
    public function sort(callable $sorter)
    {
        uasort($this->elements, $sorter);
        return $this;
    }

    /**
     * @param callable $func
     *
     * @return HashMap
     */
    public function each(callable $func) {
        foreach ($this->elements as $key => $element) {
            if( ! $func($key, $element)) return $this;
        }

        return $this;
    }



    public function clear() : void {
        $this->elements = [];
    }

    /**
     * @param array $params
     *
     * @return HashMap
     */
    public static function fromArray(array $params = []): HashMap {
        return new static($params);
    }

    public function toArray() {
        return iterator_to_array($this->getIterator());
    }

    /**
     * @return array
     */
    public function values()
    {
        return array_values($this->toArray());
    }

    /**
     * @return HashMap
     */
    public static function blank(): HashMap {
        return new static();
    }

    /**
     * @inheritdoc
     */
    public function getIterator() {
        yield from $this->elements;
    }

    /**
     * @inheritdoc
     */
    public function count() {
        return count($this->elements);
    }
}