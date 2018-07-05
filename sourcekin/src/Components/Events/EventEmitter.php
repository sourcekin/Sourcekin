<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 05.07.18.
 */

namespace Sourcekin\Components\Events;


interface EventEmitter {

    public function dispatch(Event $event);

    public function attach($event, callable $listener, int $priority = 1) : ListenerHandler;
    public function detach(ListenerHandler $listener);


}