<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 10.06.18
 *
 * @param ContainerConfigurator                                 $configurator
 *
 * @var \Symfony\Component\DependencyInjection\ContainerBuilder $container
 */

use Sourcekin\Domain\Message\CommandBus;
use Sourcekin\Domain\Message\EventBus;
use Sourcekin\Domain\Message\EventRecorder;
use SourcekinBundle\SimpleBus\BusAdapterSimpleBus;
use SourcekinBundle\SimpleBus\EventRecorderAdapter;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;

return function (ContainerConfigurator $configurator) {

    $eventBusID   = 'sourcekin.event_bus.adapter';
    $commandBusID = 'sourcekin.command_bus.adapter';
    $configurator
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->private()
        ->set($eventBusID, BusAdapterSimpleBus::class)
        ->arg('$messageBus', new Reference('event_bus'))
        ->set($commandBusID, BusAdapterSimpleBus::class)
        ->arg('$messageBus', new Reference('command_bus'))
        ->set(EventBus::class)
        ->arg('$messageBus', new reference($eventBusID))
        ->set(CommandBus::class)
        ->arg('$messageBus', new Reference($commandBusID))
        ->set(EventRecorderAdapter::class)
        ->arg('$recorder', new Reference('event_recorder'))
        ->alias(EventRecorder::class, EventRecorderAdapter::class)

    ;

    //$configurator->services()->set(\Sourcekin\Domain\Message\CommandBus::class)
};