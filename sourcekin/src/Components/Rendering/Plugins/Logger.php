<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 08.07.18.
 */

namespace Sourcekin\Components\Rendering\Plugins;


use Psr\Log\LoggerInterface;
use Sourcekin\Components\PlugIn\AbstractPlugin;
use Sourcekin\Components\PlugIn\SupportsPlugins;
use Sourcekin\Components\Rendering\Events\RenderingEvent;
use Sourcekin\Components\Rendering\Events\RenderingEvents;

class Logger extends AbstractPlugin {

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Logger constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger) { $this->logger = $logger; }


    /**
     * @param SupportsPlugins $subject
     */
    public function subscribe(SupportsPlugins $subject) {

        foreach ((new \ReflectionClass(RenderingEvents::class))->getConstants() as $eventName) {
            $this->listenerHandlers[] = $subject->attach($eventName, [$this, 'log']);
        }
    }

    public function log(RenderingEvent $event) {
        $this->logger->info($event->getName());
    }

}