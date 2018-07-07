<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 03.07.18
 *
 */

namespace Sourcekin\Components\Rendering;

use Sourcekin\Components\Common\HashMap;
use Sourcekin\Components\Events\EventEmitter;
use Sourcekin\Components\Events\SourcekinEventEmitter;
use Sourcekin\Components\Rendering\Control\ContentControl;
use Sourcekin\Components\Rendering\Events\BuildView;
use Sourcekin\Components\Rendering\Events\GetContentView;
use Sourcekin\Components\Rendering\Events\GetControl;
use Sourcekin\Components\Rendering\Exception\ControlNotFound;
use Sourcekin\Components\Rendering\Model\Content;
use Sourcekin\Components\Rendering\View\ContentView;
use Sourcekin\Components\Rendering\View\DocumentView;

class ViewBuilder {

    /**
     * @var EventEmitter
     */
    protected $emitter;

    /**
     * @var ControlCollection
     */
    protected $controls;

    /**
     * ViewBuilder constructor.
     *
     * @param ControlCollection $controls
     * @param EventEmitter      $emitter
     */
    public function __construct(ControlCollection $controls, EventEmitter $emitter = NULL) {
        $this->controls = $controls;
        $this->emitter  = $emitter ?? new SourcekinEventEmitter();
    }

    /**
     * @param ContentStream $contents
     * @param HashMap       $context
     *
     * @return ContentView
     */
    public function render(ContentStream $contents, HashMap $context) {


        // $this->buildContentView($content);
        foreach ($contents->contents() as $content) {
            $view = ContentView::fromArray($content);


        }

        return $contentView; //->process($context);

    }

    /**
     * @param Content $content
     *
     * @return bool|ContentView
     */
    protected function getContentView(Content $content) {
        $event = new GetContentView($content);
        $this->emitter->dispatch($event);
        if ($event->getView() instanceof ContentView) {
            return $event->getView();
        }

        return FALSE;
    }

    /**
     * @param Content $content
     *
     * @return ContentControl
     */
    protected function getControl(Content $content) {
        $event = new GetControl($content);
        if ($this->controls->contains($content->type()->toString())) {
            $event->setControl($this->controls->acquire($content->type()->toString()));
        }

        $this->emitter->dispatch($event);
        if (!$event->getControl() instanceof ContentControl) {
            throw ControlNotFound::withType($content->type()->toString());
        }

        return $event->getControl();
    }

    /**
     * @param Content $content
     * @param         $contentView
     *
     * @return ContentView
     */
    protected function buildView(Content $content, $contentView): ContentView {
        $event = new BuildView($content, $contentView);
        $this->emitter->dispatch($event);

        return $event->getView();
    }

    /**
     * @param                  $content
     *
     * @return ContentView
     */
    protected function buildContentView(Content $content): ContentView {
        if ($view = $this->getContentView($content)) {
            return $view;
        }

        return $this->buildView($content, $this->getControl($content)->createView($content));
    }


}