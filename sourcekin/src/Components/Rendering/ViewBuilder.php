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
use Sourcekin\Components\PlugIn\SupportsPlugins;
use Sourcekin\Components\Rendering\Control\ContentControl;
use Sourcekin\Components\Rendering\Events\BuildView;
use Sourcekin\Components\Rendering\Events\FinishView;
use Sourcekin\Components\Rendering\Events\GetContentView;
use Sourcekin\Components\Rendering\Events\GetControl;
use Sourcekin\Components\Rendering\Exception\ControlNotFound;
use Sourcekin\Components\Rendering\Model\Content;
use Sourcekin\Components\Rendering\View\ContentView;
use Sourcekin\Components\PlugIn\PluginCapabilities;
use Sourcekin\Components\Rendering\View\NodeList;
use Sourcekin\Components\Rendering\View\ViewNode;

class ViewBuilder implements SupportsPlugins
{
    use PluginCapabilities;

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
    public function __construct(ControlCollection $controls, EventEmitter $emitter = null)
    {
        $this->controls = $controls;
        $this->events   = $emitter;
    }

    /**
     * @param Content $content
     * @param HashMap $context
     *
     * @return ContentView
     */
    public function build(Content $content, HashMap $context)
    {

        if (!($view = $this->getContentView($content))) {
            $view = $this->buildContentView($content);
        }

        return $this->finishView($view, $context);

    }


    public function buildNodeList(ContentStream $stream, HashMap $context) : NodeList {
        $nodeList = new NodeList();
        foreach ($stream->contents() as $content) {
            $view = $this->build($content, $context);
            $nodeList->set((string)$view->id(), new ViewNode($view));
        }

        return $nodeList;
    }

    /**
     * @param Content $content
     *
     * @return bool|ContentView
     */
    protected function getContentView(Content $content)
    {
        $event = new GetContentView($content);
        $this->events()->dispatch($event);
        if ($event->getView() instanceof ContentView) {
            return $event->getView();
        }

        return false;
    }

    /**
     * @param Content $content
     *
     * @return ContentControl
     */
    protected function getControl(Content $content)
    {
        $event = new GetControl($content);
        if ($this->controls->contains($content->type())) {
            $event->setControl($this->controls->acquire($content->type()));
        }

        $this->events()->dispatch($event);
        if (!$event->getControl() instanceof ContentControl) {
            throw ControlNotFound::withType($content->type());
        }

        return $event->getControl();
    }

    /**
     * @param Content $content
     * @param         $contentView
     *
     * @return ContentView
     */
    protected function buildView(Content $content, $contentView): ContentView
    {
        $event = new BuildView($content, $contentView);
        $this->events()->dispatch($event);

        return $event->getView();
    }

    /**
     * @param                  $content
     *
     * @return ContentView
     */
    protected function buildContentView(Content $content): ContentView
    {
        return $this->buildView($content, $this->getControl($content)->createView($content));
    }

    /**
     * @param ContentView $view
     * @param HashMap     $context
     *
     * @return ContentView
     */
    private function finishView(ContentView $view, HashMap $context)
    {
        $event = new FinishView($view, $context);
        $this->events()->dispatch($event);

        return $event->getView();

    }


}