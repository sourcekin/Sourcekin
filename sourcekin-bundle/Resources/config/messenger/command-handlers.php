<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 09.06.18.
 */

use Sourcekin\Application as App;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;

return function (ContainerConfigurator $configurator) {
    $configurator->services()->defaults()->autowire()->autoconfigure()
        ->bind('$eventBus', new Reference('sourcekin.event_bus'))
        ->load(
            App::ns('Sourcekin.Command.Handler.'),
            App::path('/Command/Handler/*Handler.php')
        )
        ->tag('messenger.message_handler', ['bus' => 'messenger.bus.command']);
};