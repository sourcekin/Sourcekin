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

        ->set(\Sourcekin\Content\Model\DocumentRepository::class, \Sourcekin\Content\Infrastructure\DocumentRepository::class)

        ->set(\Sourcekin\Content\Model\Command\InitializeDocumentHandler::class)
        ->tag('sourcekin.command_handler')

        ->set(\Sourcekin\Content\Model\Command\AddContentHandler::class)
        ->tag('sourcekin.command_handler')

        ->set(\Sourcekin\Content\Model\Command\AddFieldHandler::class)
        ->tag('sourcekin.command_handler')
    ;
};