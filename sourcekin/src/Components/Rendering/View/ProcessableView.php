<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 06.07.18.
 */

namespace Sourcekin\Components\Rendering\View;


use Sourcekin\Components\Rendering\Processable;

class  ProcessableView extends ContentView implements Processable {


    protected $name;
    protected $dependencies;
    protected $callback;

    /**
     * Processable constructor.
     *
     * @param $name
     * @param $callback
     * @param $dependencies
     */
    public function __construct($name, $callback, $dependencies = []) {
        $this->name         = $name;
        $this->dependencies = $dependencies;
        $this->callback     = $callback;
    }

    public function name() {
        return $this->name;
    }

    public function dependencies() {
        return $this->dependencies;
    }

    public function __invoke() {
        call_user_func($this->callback);
    }

}