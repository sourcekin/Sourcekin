<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 16.06.18
 *
 */

use Broadway\CommandHandling\CommandBus;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;
use Broadway\UuidGenerator\UuidGeneratorInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;

return function (ContainerConfigurator $container) {
    $container->services()->defaults()->autoconfigure()->autowire()
              ->alias(CommandBus::class, new Reference('broadway.command_handling.event_dispatching_command_bus'))
              ->alias(EventBus::class, new Reference('broadway.event_handling.event_bus'))
              ->alias(UuidGeneratorInterface::class, new Reference('broadway.uuid.generator'))
              ->alias(EventStore::class, new Reference('broadway.event_store'))
    ;
};