<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 08.07.18
 *
 */

namespace Sourcekin\Components\Rendering\Events;

use Sourcekin\Components\Common\HashMap;

class BeforeRender extends RenderingEvent
{

    /**
     * @var HashMap $nodes
     */
    protected $nodes;

    /**
     * @var HashMap $context
     */
    protected $context;

    /**
     * BeforeRender constructor.
     *
     * @param HashMap $views
     * @param HashMap $context
     */
    public function __construct(HashMap $views, HashMap $context)
    {
        $this->nodes   = $views;
        $this->context = $context;
    }

    /**
     * @return HashMap
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
        return RenderingEvents::PRE_RENDER;
    }
}