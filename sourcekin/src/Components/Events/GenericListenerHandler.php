<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 05.07.18.
 */

namespace Sourcekin\Components\Events;


class GenericListenerHandler implements ListenerHandler {

    /**
     * @var callable
     */
    protected $callback;
    /**
     * @var int
     */
    protected $priority;

    /**
     * GenericListenerHandler constructor.
     *
     * @param callable $callback
     */
    public function __construct(callable $callback, int $priority = 1) {
        $this->callback = $callback;
        $this->priority = $priority;
    }

    /**
     * @return callable
     */
    public function getEventListener()  :callable  {
        return $this->callback;
    }

    public function priority(): int {
        return $this->priority;
    }


}