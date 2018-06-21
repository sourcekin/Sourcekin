<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 21.06.18
 *
 */

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return function (ContainerConfigurator $container) {
    $container
        ->services()->defaults()->autowire()->autoconfigure()->tag('controller.service_arguments')
        // services
        ->set(\SourcekinBundle\Controller\ApiCommandController::class)

    ;
};