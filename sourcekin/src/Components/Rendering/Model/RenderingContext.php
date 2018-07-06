<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 06.07.18.
 */

namespace Sourcekin\Components\Rendering\Model;


/**
 * Class RenderingContext
 */
class RenderingContext {

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @param $name
     *
     * @return Param
     */
    public function get($name) {
        return $this->params[$name];
    }

    /**
     * @param $name
     * @param $value
     */
    public function set($name, $value) {
        $this->params[$name] = Param::fromData($name, $value);
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function has($name) {
        return array_key_exists($name, $this->params);
    }

    /**
     * @param $name
     */
    public function remove($name) {
        if ($this->has($name)) {
            unset($this->params[$name]);
        }
    }

    /**
     * @param array $params
     *
     * @return RenderingContext
     */
    public static function fromArray(array $params = []): RenderingContext {
        $context = new static();
        foreach ($params as $key => $value) {
            $context->set($key, $value);
        }

        return $context;
    }

    /**
     * @return RenderingContext
     */
    public static function blank(): RenderingContext {
        return new static();
    }
}