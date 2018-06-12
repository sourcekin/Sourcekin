<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 09.06.18.
 */

use Sourcekin\EventHandling\MessageBusInterface;
use SourcekinBundle\Messenger\MessageBus;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;

return function (ContainerConfigurator $configurator)  {

    $configurator
        ->services()
        ->set('sourcekin.command_bus', MessageBus::class)
        ->arg('$bus', new Reference('messenger.bus.command'))
        ->autoconfigure()
        ->autowire()
        ->private()
        ->alias(MessageBusInterface::class, 'sourcekin.command_bus')
    ;

    $configurator
        ->services()
        ->set('sourcekin.event_bus', MessageBus::class)
        ->arg('$bus', new Reference('messenger.bus.event'))
        ->autowire()
        ->autoconfigure()
        ->private()
    ;


};