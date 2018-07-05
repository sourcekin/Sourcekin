<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 05.07.18.
 */

namespace Sourcekin\Components\Rendering;


use Sourcekin\Components\Rendering\Model\Content;
use Sourcekin\Components\Rendering\View\ContentView;

class FinishView extends RenderingEvent {

    /**
     * @var Content
     */
    protected $content;
    /**
     * @var ContentView
     */
    protected $view;

    /**
     * FinishView constructor.
     *
     * @param Content     $content
     * @param ContentView $view
     */
    public function __construct(Content $content, ContentView $view) {
        $this->content = $content;
        $this->view    = $view;
    }


    /**
     * @return Content
     */
    public function getContent(): Content {
        return $this->content;
    }

    /**
     * @return ContentView
     */
    public function getView(): ContentView {
        return $this->view;
    }

    /**
     * @param ContentView $view
     *
     * @return $this
     */
    public function setView(ContentView $view) {
        $this->view = $view;

        return $this;
    }

    public function getName() {
        return RenderingEvents::FINISH;
    }
}