<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 17.06.18.
 */

namespace Sourcekin\Components\EventSourcing;


use Prooph\EventSourcing\AggregateChanged;

trait ApplyEventCapabilities {

    protected function apply(AggregateChanged $event) : void {
        $method    = 'on'.ucfirst((new \ReflectionClass($event))->getShortName());
        if(! method_exists($this, $method)) return;
        $this->$method($event);
    }
}