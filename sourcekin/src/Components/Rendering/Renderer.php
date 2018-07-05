<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 03.07.18
 *
 */

namespace Sourcekin\Components\Rendering;

use Sourcekin\Components\Events\EventEmitter;
use Sourcekin\Components\Events\SourcekinEventEmitter;
use Sourcekin\Components\Rendering\Control\ContentControl;
use Sourcekin\Components\Rendering\Exception\ControlNotFound;
use Sourcekin\Components\Rendering\Model\Content;
use Sourcekin\Components\Rendering\View\ContentView;

class Renderer {

    /**
     * @var EventEmitter
     */
    protected $emitter;

    /**
     * @var ControlCollection
     */
    protected $controls;

    /**
     * Renderer constructor.
     *
     * @param ControlCollection $controls
     * @param EventEmitter      $emitter
     */
    public function __construct(ControlCollection $controls, EventEmitter $emitter = NULL) {
        $this->controls = $controls;
        $this->emitter  = $emitter ?? new SourcekinEventEmitter();
    }

    /**
     * @param $content
     *
     * @return ContentView
     */
    public function render(Content $content) {

        if( $view = $this->getContentView($content)) return $view;

        $control     = $this->getControl($content);
        $contentView = $control->withContent($content)->createView();

        return $this->finishView($content, $contentView);

    }

    /**
     * @param Content $content
     *
     * @return bool|ContentView
     */
    protected function getContentView(Content $content) {
        $event = new GetContentView($content);
        $this->emitter->dispatch($event);
        if ( $event->getView() instanceof ContentView ) {
            return $event->getView();
        }
        return false;
    }

    /**
     * @param Content $content
     *
     * @return ContentControl
     */
    protected function getControl(Content $content) {
        $event = new GetControl($content);
        if( $this->controls->contains($content->type()->toString())) {
            $event->setControl($this->controls->acquire($content->type()->toString()));
        }

        $this->emitter->dispatch($event);
        if( ! $event->getControl() instanceof ContentControl)
            throw ControlNotFound::withType($content->type()->toString());

        return $event->getControl();
    }

    /**
     * @param Content $content
     * @param         $contentView
     *
     * @return ContentView
     */
    protected function finishView(Content $content, $contentView): ContentView {
        $event = new FinishView($content, $contentView);
        $this->emitter->dispatch($event);

        return $event->getView();
    }

}