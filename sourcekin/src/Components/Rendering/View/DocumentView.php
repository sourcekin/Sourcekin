<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 03.07.18
 *
 */

namespace Sourcekin\Components\Rendering\View;

class DocumentView
{
    protected $id;

    protected $attributes = [];

    protected $vars = [];

    protected $children = [];

    /**
     * DocumentView constructor.
     *
     * @param       $id
     * @param array $attributes
     * @param array $vars
     */
    public function __construct($id, array $vars = [], array $attributes = []) {
        $this->id         = $id;
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

    public function append(ContentView $view) {
        $this->children[$view->id()] = $view;
    }


}