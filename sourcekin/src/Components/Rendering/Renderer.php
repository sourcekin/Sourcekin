<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 03.07.18
 *
 */

namespace Sourcekin\Components\Rendering;

use Sourcekin\Components\Events\EventDispatcher;
use Sourcekin\Components\Events\EventEmitter;
use Sourcekin\Components\Rendering\Model\Content;
use Sourcekin\Components\Rendering\Views\ContentView;

class Renderer {

    /**
     * @var EventEmitter
     */
    protected $emitter;

    /**
     * Renderer constructor.
     *
     * @param EventEmitter $emitter
     */
    public function __construct(EventEmitter $emitter) {
        $this->emitter = $emitter;
    }

    /**
     * @param $content
     *
     * @return ContentView
     */
    public function render(Content $content) {


        // resolve content handlers

        // call each content handler with individual content and context (Document-View?)

        //


        return new ContentView();
    }


}