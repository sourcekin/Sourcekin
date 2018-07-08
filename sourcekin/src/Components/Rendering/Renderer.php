<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 08.07.18
 *
 */

namespace Sourcekin\Components\Rendering;

use Sourcekin\Components\Common\HashMap;
use Sourcekin\Components\Events\EventEmitter;
use Sourcekin\Components\PlugIn\SupportsPlugins;
use Sourcekin\Components\Rendering\Events\RenderNodes;
use Sourcekin\Components\Rendering\Events\RenderNode;
use Sourcekin\Components\Rendering\View\ContentView;
use Sourcekin\Components\Rendering\View\NodeList;
use Sourcekin\Components\Rendering\View\ViewNode;
use Sourcekin\Components\PlugIn\PluginCapabilities;

class Renderer implements SupportsPlugins
{
    use PluginCapabilities;
    /**
     * @var ViewBuilder
     */
    protected $builder;


    /**
     * Renderer constructor.
     *
     * @param ViewBuilder  $builder
     * @param EventEmitter $emitter
     */
    public function __construct(ViewBuilder $builder, EventEmitter $emitter = null)
    {
        $this->builder = $builder;
        $this->events = $emitter;
    }

    public function render(ContentStream $stream, HashMap $context) : string {

        $nodeList = $this->builder->buildNodeList($stream, $context);
        $event = RenderNodes::preRender($nodeList, $context);
        $this->events()->dispatch($event);

        $event->nodes()->each(function($id, ViewNode $view) use ($nodeList, $context) {
             $this->renderNode($view, $context);
             return true;
        });

        $event = RenderNodes::postRender($nodeList, $context);
        $this->events()->dispatch($event);

        return (string)$event->nodes()->rootNodes();
    }

    /**
     * @param ViewNode $node
     * @param HashMap  $context
     *
     * @return ViewNode
     */
    protected function renderNode(ViewNode $node, HashMap $context)
    {
        $event = new RenderNode($node, $context);
        $this->events()->dispatch($event);
        return $event->node();
    }



}