<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 11.06.18
 *
 */

namespace Sourcekin\EventHandling;

interface EventRecorder
{
    public function record($event);
    public function messages();
    public function erase();
}