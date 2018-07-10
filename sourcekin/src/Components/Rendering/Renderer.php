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
use Sourcekin\Components\Rendering\View\ViewNode;
use Sourcekin\Components\PlugIn\PluginCapabilities;
use Symfony\Component\Stopwatch\Stopwatch;

class Renderer implements SupportsPlugins
{
    use PluginCapabilities;

    /**
     * @var ViewBuilder
     */
    protected $builder;

    /**
     * @var Stopwatch
     */
    protected $watch;

    /**
     * Renderer constructor.
     *
     * @param ViewBuilder  $builder
     * @param EventEmitter $emitter
     */
    public function __construct(ViewBuilder $builder, EventEmitter $emitter = null, Stopwatch $watch = null)
    {
        $this->builder = $builder;
        $this->events  = $emitter;
        $this->watch = $watch;
    }



    public function render(ContentStream $stream, HashMap $context): string
    {
        if( $this->watch) $this->watch->start('building node list');
        $nodeList = $this->builder->buildNodeList($stream, $context);
        if( $this->watch) $this->watch->stop('building node list');

        if( $this->watch) $this->watch->start('rendering');
        $event    = RenderNodes::preRender($nodeList, $context);
        $this->events()->dispatch($event);

        $event->nodes()->each(
            function ($id, ViewNode $view) use ($nodeList, $context) {
                $this->renderNode($view, $context);

                return true;
            }
        )
        ;

        $event = RenderNodes::postRender($nodeList, $context);
        $this->events()->dispatch($event);
        if( $this->watch) $this->watch->stop('rendering');
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

        $this->events()->dispatch(RenderNode::start($node, $context));
        $this->events()->dispatch(RenderNode::render($node, $context));
        $this->events()->dispatch(RenderNode::stop($node, $context));

        return $node;
    }


}