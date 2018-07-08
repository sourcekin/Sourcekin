<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 08.07.18
 *
 */

namespace Sourcekin\Components\Rendering\Events;

use Sourcekin\Components\Common\HashMap;
use Sourcekin\Components\Rendering\View\NodeList;

class RenderNodes extends RenderingEvent
{

    /**
     * @var NodeList $nodes
     */
    protected $nodes;

    /**
     * @var HashMap $context
     */
    protected $context;

    /**
     * @var string
     */
    protected $name;

    /**
     * RenderNodes constructor.
     *
     * @param          $name
     * @param NodeList $views
     * @param HashMap  $context
     */
    protected function __construct($name, NodeList $views, HashMap $context)
    {
        $this->nodes   = $views;
        $this->context = $context;
        $this->name    = $name;
    }

    public static function preRender(NodeList $views, HashMap $context)
    {
        return new static(RenderingEvents::PRE_RENDER, $views, $context);
    }

    public static function postRender(NodeList $views, HashMap $context)
    {
        return new static(RenderingEvents::POST_RENDER, $views, $context);
    }

    /**
     * @return NodeList
     */
    public function nodes(): HashMap
    {
        return $this->nodes;
    }

    /**
     * @return HashMap
     */
    public function context(): HashMap
    {
        return $this->context;
    }


    public function getName()
    {
        return $this->name;
    }
}