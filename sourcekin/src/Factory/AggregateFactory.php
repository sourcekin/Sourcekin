<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 15.06.18
 *
 */

namespace Sourcekin\Factory;

use Sourcekin\Domain\AggregateRootInterface;
use Sourcekin\Domain\EventStream;

interface AggregateFactory
{
    public function make($class, EventStream $events) : AggregateRootInterface;

}