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
     */
    public function set($name, $value) {
        $this->elements[$name] = $value;
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
     */
    public function remove($name) {
        if ($this->has($name)) {
            unset($this->elements[$name]);
        }
    }

    public function removeElement($element) {
        while( false !== ($key = array_search($element, $this->elements))){
            unset($this->elements[$key]);
        }
    }

    public function filter(callable $filter) : HashMap {
        return new static(array_filter($this->elements, $filter));
    }

    public function map(callable $map) : HashMap {
        return new static(array_map($map, $this->elements));
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