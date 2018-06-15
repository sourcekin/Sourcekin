<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 15.06.18.
 */

namespace SourcekinBundle\Broadway;


use Broadway\CommandHandling\CommandHandler;

class CommandHandlerDecorator implements CommandHandler {

    /**
     * @var callable
     */
    protected $handler;

    /**
     * CommandHandlerDecorator constructor.
     *
     * @param callable $handler
     */
    public function __construct(callable $handler) { $this->handler = $handler; }


    /**
     * @param mixed $command
     */
    public function handle($command) {
        return call_user_func($this->handler, $command);
    }
}