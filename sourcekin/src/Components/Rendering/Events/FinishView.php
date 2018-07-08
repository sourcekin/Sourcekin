<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 07.07.18
 *
 */

namespace Sourcekin\Components\Rendering\Events;

use Sourcekin\Components\Common\HashMap;
use Sourcekin\Components\Rendering\View\ContentView;

class FinishView extends RenderingEvent
{
    /**
     * @var ContentView
     */
    protected $view;

    /**
     * @var HashMap $context
     */
    protected $context;

    /**
     * FinishView constructor.
     *
     * @param ContentView $view
     * @param HashMap     $context
     */
    public function __construct(ContentView $view, HashMap $context)
    {
        $this->view    = $view;
        $this->context = $context;
    }

    /**
     * @return ContentView
     */
    public function getView(): ContentView
    {
        return $this->view;
    }

    /**
     * @return HashMap
     */
    public function getContext(): HashMap
    {
        return $this->context;
    }


    public function getName()
    {
        return RenderingEvents::FINISH_VIEW;
    }
}