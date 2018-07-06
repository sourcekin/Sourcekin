<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 06.07.18.
 */

namespace Sourcekin\Components\Rendering\Model;


class RenderingContext {

    protected $params = [];

    /**
     * @param $name
     *
     * @return Param
     */
    public function get($name) {
        return $this->params[$name];
    }

    public function set($name, $value) {
        $this->params[$name] = Param::fromData($name, $value);
    }

    public function has($name) {
        return array_key_exists($name, $this->params);
    }

    public function remove($name) {
        if( $this->has($name)) unset($this->params[$name]);
    }

    public static function fromArray(array $params = []): RenderingContext {
        $context = new static();
        foreach ($params as $key => $value) {
            $context->set($key, $value);
        }
        return $context;
    }

    public static function blank(): RenderingContext {
        return new static();
    }
}