<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 19.06.18
 *
 */

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function(ContainerConfigurator $configurator) {
    $configurator->services()->defaults()->autoconfigure()->autowire()
        ->load(\Sourcekin\Application::ns('Sourcekin.'), \Sourcekin\Application::path('/*/*Module.php'))
        ->tag('sourcekin.module');
};