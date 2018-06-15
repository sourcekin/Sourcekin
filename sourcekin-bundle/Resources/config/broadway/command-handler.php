<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 15.06.18.
 */

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function(ContainerConfigurator $configurator){

    $configurator->services()->defaults()->autowire()->autoconfigure()
    ->load(\Sourcekin\Application::ns('Sourcekin.Command.Handler.'),
        \Sourcekin\Application::path('/Command/Handler/*Handler.php'))
    ->tag('sourcekin.command_handler');

};