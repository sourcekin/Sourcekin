<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 10.06.18
 *
 */

namespace SourcekinBundle\SimpleBus;

use SimpleBus\Message\Bus\Middleware\MessageBusMiddleware;
use SourcekinBundle\Console\MessageReceiver;

class ConsoleMessageMiddleware implements MessageBusMiddleware
{

    /**
     * @var MessageReceiver
     */
    protected $receiver;

    /**
     * ConsoleMessageMiddleware constructor.
     *
     * @param MessageReceiver $receiver
     */
    public function __construct(MessageReceiver $receiver) { $this->receiver = $receiver; }


    /**
     * The provided $next callable should be called whenever the next middleware should start handling the message.
     * Its only argument should be a Message object (usually the same as the originally provided message).
     *
     * @param object   $message
     * @param callable $next
     *
     * @return void
     */
    public function handle($message, callable $next)
    {
        $this->receiver->receive($message);
        $next($message);
    }
}