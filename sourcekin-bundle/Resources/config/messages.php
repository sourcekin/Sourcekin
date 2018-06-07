<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 05.06.18
 *
 */

use Sourcekin\Infrastructure\DependencyInjection\ConfigurationHelper;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function(ContainerConfigurator $container){
    $container->services()->defaults()->autowire()->private()
    ->load("Sourcekin\\Domain\\Command\\Handler\\", ConfigurationHelper::getPackageDir() . '/Domain/Command/Handler/*Handler.php')
    ->tag('sourcekin.domain.command_handler');

};