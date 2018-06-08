<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 07.06.18
 *
 */

use Sourcekin\Domain\Message\DomainBusInterface;
use Sourcekin\Infrastructure\DependencyInjection\ConfigurationHelper;
use Sourcekin\Infrastructure\Messenger\DomainBus;
use Sourcekin\Infrastructure\Messenger\FallbackMessageHandler;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function(ContainerConfigurator $container) {
    $container
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->private()
        ->set(DomainBus::class)
        ->alias(DomainBusInterface::class, DomainBus::class)
    ;

    $container
        ->services()
        ->load('Sourcekin\\Domain\\Command\\Handler\\', ConfigurationHelper::getPackagePath('/Domain/Command/Handler/*Handler.php'))
        ->private()
        ->lazy()
        ->autowire()
        ->autoconfigure()
        ->tag('sourcekin.domain.message_handler');
    /*
    $domainBus = $container->register(DomainBus::class);
    $domainBus->setAutowired(true)->setAutoconfigured(true);
    $container->setAlias(DomainBusInterface::class, DomainBus::class);
    */
};