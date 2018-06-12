<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 10.06.18
 *
 */
use Sourcekin\Application as App;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;

return function (ContainerConfigurator $configurator) {
    $configurator->services()->defaults()->autowire()->autoconfigure()
                 ->load(
                     App::ns('Sourcekin.Command.Handler.'),
                     App::path('/Command/Handler/*Handler.php')
                 )
                 ->tag('command_handler');
};