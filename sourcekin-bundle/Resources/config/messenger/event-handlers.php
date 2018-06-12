<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 09.06.18.
 */

use Sourcekin\Application as App;
use SourcekinBundle\Messenger\FallbackEventHandler;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $configurator) {

    $service = $configurator
        ->services()
        ->set(FallbackEventHandler::class)
        ->autoconfigure()
        ->autowire()
        ;

    $events = array_map(
        function($file) {
            return App::ns(sprintf('Sourcekin.Event.%s', basename($file, '.php')));
            },
        glob(App::path('/Event/*.php'))
    );

    foreach ($events as $event) {
        $service->tag('messenger.message_handler', ['bus' => 'messenger.bus.event', 'handles' => $event]);
    }
};