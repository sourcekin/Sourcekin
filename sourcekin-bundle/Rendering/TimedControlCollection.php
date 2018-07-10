<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 10.07.18
 *
 */

namespace SourcekinBundle\Rendering;

use Sourcekin\Components\Rendering\Control\ContentControl;
use Sourcekin\Components\Rendering\ControlCollection;
use Symfony\Component\Stopwatch\Stopwatch;

class TimedControlCollection implements ControlCollection
{
    /**
     * @var ControlCollection
     */
    protected $collection;

    /**
     * @var Stopwatch
     */
    protected $stopwatch;

    /**
     * TimedControlCollection constructor.
     *
     * @param ControlCollection $collection
     * @param Stopwatch         $stopwatch
     */
    public function __construct(ControlCollection $collection, ?Stopwatch $stopwatch)
    {
        $this->collection = $collection;
        $this->stopwatch  = $stopwatch;
    }

    protected function watchOn($name)
    {
        if( $this->stopwatch) $this->stopwatch->start($name);
    }

    protected function watchOff($name) {
        if( $this->stopwatch) $this->stopwatch->stop($name);
    }

    public function contains($name): bool
    {
        $this->watchOn('contains ' . $name);
        $value = $this->collection->contains($name);
        $this->watchOff('contains ' . $name);
        return $value;
    }

    public function acquire($name): ContentControl
    {
        $this->watchOn('acquire ' . $name);
        $value = $this->collection->acquire($name);
        $this->watchOff('acquire ' . $name);

        return $value;
    }

}