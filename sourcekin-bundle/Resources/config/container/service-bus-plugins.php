<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 20.06.18.
 */

use Symfony\Component\DependencyInjection\Reference;

return function(\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $container){
    $container
        ->services()->defaults()->autoconfigure()->autowire()->private()

        ->set(\Prooph\Common\Messaging\MessageConverter::class, \Prooph\Common\Messaging\NoOpMessageConverter::class)
        ->set(\Prooph\Bundle\ServiceBus\MessageContext\DefaultMessageDataConverter::class)
        ->set(\Prooph\Bundle\ServiceBus\MessageContext\ContextFactory::class)

        ->arg('$messageDataConverter', new Reference(\Prooph\Bundle\ServiceBus\MessageContext\DefaultMessageDataConverter::class))

        ->set('sourcekin.command_bus.logger', \Prooph\Bundle\ServiceBus\Plugin\PsrLoggerPlugin::class)
        ->arg('$logger', new Reference('logger', \Symfony\Component\DependencyInjection\ContainerInterface::NULL_ON_INVALID_REFERENCE))
        ->tag('monolog.logger', ['channel' => 'command_bus'])
        ->tag('sourcekin.plugin', ['type' => 'command_bus'])

        ->set('sourcekin.event_bus.logger', \Prooph\Bundle\ServiceBus\Plugin\PsrLoggerPlugin::class)
        ->arg('$logger', new Reference('logger', \Symfony\Component\DependencyInjection\ContainerInterface::NULL_ON_INVALID_REFERENCE))
        ->tag('monolog.logger', ['channel' => 'event_bus'])
        ->tag('sourcekin.plugin', ['type' => 'event_bus'])

        ->set('sourcekin.query_bus.logger', \Prooph\Bundle\ServiceBus\Plugin\PsrLoggerPlugin::class)
        ->arg('$logger', new Reference('logger', \Symfony\Component\DependencyInjection\ContainerInterface::NULL_ON_INVALID_REFERENCE))
        ->tag('monolog.logger', ['channel' => 'query_bus'])
        ->tag('sourcekin.plugin', ['type' => 'query_bus'])
    ;
};