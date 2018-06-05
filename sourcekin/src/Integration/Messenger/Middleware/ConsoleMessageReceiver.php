<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 05.06.18
 *
 */

namespace Sourcekin\Integration\Messenger\Middleware;

use Sourcekin\Integration\Console\MessageReceiver;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;

class ConsoleMessageReceiver implements MiddlewareInterface
{

    /**
     * @var MessageReceiver
     */
    protected $receiver;

    /**
     * ConsoleMessageReceiver constructor.
     *
     * @param MessageReceiver $receiver
     */
    public function __construct(MessageReceiver $receiver) {
        $this->receiver = $receiver;
    }


    /**
     *
     * @param object $message
     *
     * @return mixed
     */
    public function handle($message, callable $next)
    {
        $this->receiver->receive($message);
        return $next($message);
    }
}