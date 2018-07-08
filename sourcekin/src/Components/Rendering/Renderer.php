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
use Sourcekin\Components\Rendering\Events\BeforeRender;
use Sourcekin\Components\Rendering\Events\RenderNode;
use Sourcekin\Components\Rendering\View\ContentView;
use Sourcekin\Components\Rendering\View\ViewNode;

class Renderer
{
    /**
     * @var ViewBuilder
     */
    protected $builder;

    /**
     * @var EventEmitter
     */
    protected $emitter;

    public function render(ContentStream $stream, HashMap $context) {

        /** @var ContentView $list */
        $nodeList = new HashMap();
        foreach ($stream->contents() as $content) {
            $view = $this->builder->build($content, $context);
            $nodeList->set((string)$view->id(), new ViewNode($view));
        }

        $event = new BeforeRender($nodeList, $context);
        $this->emitter->dispatch($event);


        $event->nodes()->each(function($id, ViewNode $view) use ($nodeList, $context) {

            $this->renderNode($view, $context);

            if( $nodeList->has((string)$view->parent())) {
                $nodeList->get((string)$view->parent())->addChild($view);
            }

        });

        $nodeList->filter(function(ViewNode $node){
            return $node->isRoot();
        });

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
        $this->emitter->dispatch($event);
        return $event->node();

    }

}