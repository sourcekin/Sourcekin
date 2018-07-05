<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 05.07.18.
 */

namespace Sourcekin\Components\Rendering;


use Sourcekin\Components\Rendering\Model\Content;
use Sourcekin\Components\Rendering\View\ContentView;

class GetContentView extends RenderingEvent {

    /**
     * @var Content
     */
    protected $content;

    /**
     * @var ContentView
     */
    protected $view;

    /**
     * GetContentView constructor.
     *
     * @param Content $content
     */
    public function __construct(Content $content) {
        $this->content = $content;
    }

    /**
     * @return ContentView|null
     */
    public function getView() {
        return $this->view;
    }

    /**
     * @param ContentView $view
     *
     * @return $this
     */
    public function setView($view) {
        $this->view = $view;

        return $this;
    }

    public function getName() {
        return RenderingEvents::VIEW;
    }
}