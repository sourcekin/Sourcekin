<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 08.07.18
 *
 */

namespace Sourcekin\Components\Rendering\Events;

use Sourcekin\Components\Common\HashMap;
use Sourcekin\Components\Rendering\View\ViewNode;

class RenderNode extends RenderingEvent
{

    /**
     * @var ViewNode
     */
    protected $node;

    /**
     * @var HashMap $context
     */
    protected $context;

    /**
     * RenderNode constructor.
     *
     * @param ViewNode $node
     * @param HashMap  $context
     */
    public function __construct(ViewNode $node, HashMap $context)
    {
        $this->node    = $node;
        $this->context = $context;
    }

    public function node()
    {
        return $this->node;
    }

    public function context()
    {
        return $this->context;
    }

    public function getName()
    {
        return RenderingEvents::RENDER;
    }
}