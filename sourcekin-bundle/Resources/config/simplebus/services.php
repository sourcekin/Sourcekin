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

use SourcekinBundle\SimpleBus\BusAdapterSimpleBus;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;

return function (ContainerConfigurator $configurator) {

    $eventBusID   = 'sourcekin.eventbus.adapter';
    $commandBusID = 'sourcekin.commandbus.adapter';
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
        ->set(\Sourcekin\Domain\Message\EventBus::class)
        ->arg('$messageBus', new reference($eventBusID))
        ->set(\Sourcekin\Domain\Message\CommandBus::class)
        ->arg('$messageBus', new Reference($commandBusID))
    ;

    //$configurator->services()->set(\Sourcekin\Domain\Message\CommandBus::class)
};