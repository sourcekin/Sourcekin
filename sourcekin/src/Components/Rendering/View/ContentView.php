<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 03.07.18
 *
 */

namespace Sourcekin\Components\Rendering\View;

class ContentView
{
    protected $id;

    protected $parent = null;

    protected $attributes = [];

    protected $vars = [];

    /**
     * ContentView constructor.
     *
     * @param       $id
     * @param null  $parent
     * @param array $attributes
     * @param array $vars
     */
    public function __construct($id, $parent, array $vars = [], array $attributes = []) {
        $this->id         = $id;
        $this->parent     = $parent;
        $this->attributes = $attributes;
        $this->vars       = $vars;
    }


    public function id() {
        return $this->id;
    }

    public function attributes() {
        return $this->attributes;
    }

    public function vars() {
        return $this->vars;
    }

    public function parent() {
        return $this->parent;
    }

    public function append(ContentView $view) {

    }
}