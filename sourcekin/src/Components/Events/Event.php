<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 28.04.18
 *
 */

namespace Sourcekin\Components\Events;

abstract class Event
{
    protected $stoppedPropagation = false;

    abstract public function getName();

    public function stopPropagation(bool $stop = true){
        $this->stoppedPropagation = $stop;
    }

    public function isPropagationStopped() : bool {
        return $this->stoppedPropagation;
    }
}