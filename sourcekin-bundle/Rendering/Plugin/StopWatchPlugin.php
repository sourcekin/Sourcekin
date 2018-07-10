<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 09.07.18
 *
 */

namespace SourcekinBundle\Rendering\Plugin;

use Sourcekin\Components\PlugIn\AbstractPlugin;
use Sourcekin\Components\PlugIn\SupportsPlugins;
use Sourcekin\Components\Rendering\Events\BuildView;
use Sourcekin\Components\Rendering\Events\FinishView;
use Sourcekin\Components\Rendering\Events\RenderingEvents;
use Symfony\Component\Stopwatch\Stopwatch;

class StopWatchPlugin extends AbstractPlugin
{

    /**
     * @var Stopwatch
     */
    protected $stopwatch;

    /**
     * StopWatchPlugin constructor.
     *
     * @param Stopwatch $stopwatch
     */
    public function __construct(?Stopwatch $stopwatch) { $this->stopwatch = $stopwatch; }

    /**
     * @param SupportsPlugins $subject
     */
    public function subscribe(SupportsPlugins $subject)
    {
        $this->listenerHandlers[] = $subject->attach(
            RenderingEvents::PRE_RENDER,
            function () { $this->watchOn(RenderingEvents::RENDER); }
        );
        $this->listenerHandlers[] = $subject->attach(
            RenderingEvents::POST_RENDER,
            function () { $this->watchOff(RenderingEvents::RENDER); }
        );
        $this->listenerHandlers[] = $subject->attach(
            RenderingEvents::START_RENDER,
            function () { $this->watchOn(RenderingEvents::RENDER); }
        );
        $this->listenerHandlers[] = $subject->attach(
            RenderingEvents::STOP_RENDER,
            function () { $this->watchOff(RenderingEvents::RENDER); }
        );

        $this->listenerHandlers[] = $subject->attach(
            RenderingEvents::VIEW,
            function () { $this->watchOn('view'); }
        );

        $this->listenerHandlers[] = $subject->attach(
            RenderingEvents::FINISH_VIEW,
            function () { $this->watchOff('view'); }
        );

    }

    protected function watchOn($name)
    {
        if ($this->stopwatch) {
            $this->stopwatch->start($name);
        }
    }

    protected function watchOff($name)
    {
        if ($this->stopwatch) {
            $this->stopwatch->stop($name);
        }
    }
}