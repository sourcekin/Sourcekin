<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 08.07.18
 *
 */

namespace Sourcekin\Components\Rendering\Events;

use Doctrine\DBAL\Schema\View;
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
     * @var string
     */
    protected $name = RenderingEvents::RENDER;

    /**
     * RenderNode constructor.
     *
     * @param ViewNode $node
     * @param HashMap  $context
     */
    public function __construct(ViewNode $node, HashMap $context, $name = RenderingEvents::RENDER)
    {
        $this->node    = $node;
        $this->context = $context;
        $this->name = $name;
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
        return $this->name;
    }

    public static function start(ViewNode $node, HashMap $context)
    {
        return new static($node, $context, RenderingEvents::START_RENDER);
    }

    public static function stop(ViewNode $node, HashMap $context)
    {
        return new static($node, $context, RenderingEvents::STOP_RENDER);
    }

    public static function render(ViewNode $node, HashMap $context)
    {
        return new static($node, $context);
    }
}