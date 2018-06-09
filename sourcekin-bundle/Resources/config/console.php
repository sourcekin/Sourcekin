<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 07.06.18
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
        ->set(MessageReceiver::class)
        ->autoconfigure()
        ->autowire()
        ->tag('kernel.event_listener', ['event' => ConsoleEvents::COMMAND, 'method' => 'onCommand'])
        ->tag('kernel.event_listener', ['event' => ConsoleEvents::TERMINATE, 'method' => 'onTerminate'])
        ;

    $configurator
        ->services()
        ->set('messenger.bus.event.event_receiver', EventReceiver::class)
        ->autowire()
        ->autoconfigure()
        ->decorate('messenger.bus.event')
        ->arg('$eventBus', new Reference('messenger.bus.event.event_receiver.inner'))
        ;
};