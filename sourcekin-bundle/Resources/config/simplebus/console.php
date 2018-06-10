<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 10.06.18
 *
 */

use SourcekinBundle\Console\MessageReceiver;
use SourcekinBundle\Messenger\EventReceiver;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;

return function(ContainerConfigurator $configurator){
    $configurator
        ->services()
        ->defaults()
        ->autoconfigure()
        ->autowire()
        ->private()
        ->set(MessageReceiver::class)
        ->tag('kernel.event_listener', ['event' => ConsoleEvents::COMMAND, 'method' => 'onCommand'])
        ->tag('kernel.event_listener', ['event' => ConsoleEvents::TERMINATE, 'method' => 'onTerminate'])
        ->set(\SourcekinBundle\SimpleBus\ConsoleMessageMiddleware::class)
        ->tag('event_bus_middleware')
    ;




};