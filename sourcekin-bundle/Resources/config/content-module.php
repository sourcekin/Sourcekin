<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 21.06.18
 *
 */
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;

return function (ContainerConfigurator $container) {
    $container
        ->services()->defaults()->autowire()->autoconfigure()->private()

        ->set(\Sourcekin\User\Model\UserRepository::class, \Sourcekin\User\Infrastructure\UserRepository::class)

        ->set(\Sourcekin\Content\Model\Command\InitializeDocumentHandler::class)
        ->tag('sourcekin.command_handler')

    ;
};