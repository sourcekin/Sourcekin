<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 08.07.18
 *
 */

namespace Sourcekin\Components\Plugin;

use Sourcekin\Components\Events\ListenerHandler;

interface SupportsPlugins
{
    public function attach(string $eventName, callable $listener, int $priority = 0): ListenerHandler;
    public function detach(ListenerHandler $handler): void;
}