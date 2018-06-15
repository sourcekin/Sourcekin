<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 15.06.18.
 */

use Sourcekin\CommandHandling\CommandBus;
use Sourcekin\EventDispatcher\Dispatcher;
use Sourcekin\EventHandling\EventBus;
use SourcekinBundle\Broadway\CommandBusAdapter;
use SourcekinBundle\Broadway\DispatcherAdapter;
use SourcekinBundle\Broadway\EventBusAdapter;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;

return function (ContainerConfigurator $configurator) {

    $configurator
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->set(CommandBusAdapter::class)->arg('$bus', new Reference('broadway.command_handling.command_bus'))
        ->alias(CommandBus::class, CommandBusAdapter::class)
        ->set(EventBusAdapter::class)->arg('$bus', new Reference('broadway.event_handling.event_bus'))
        ->alias(EventBus::class, EventBusAdapter::class)
        ->set(DispatcherAdapter::class)->arg('$dispatcher', new Reference('broadway.event_dispatcher'))
        ->alias(Dispatcher::class, DispatcherAdapter::class);
    ;

};