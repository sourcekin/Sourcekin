<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 21.06.18
 *
 */
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Parameter;
use Sourcekin\Application as App;
use Symfony\Component\DependencyInjection\Reference;

return function (ContainerConfigurator $container) {
    $container
        ->services()->defaults()->autowire()->autoconfigure()->private()

        ->set(\Sourcekin\Content\Model\DocumentRepository::class, \Sourcekin\Content\Infrastructure\DocumentRepository::class)

        ->load(App::ns('Sourcekin.Content.Model.Handler.Command.'), App::path('/Content/Model/Handler/Command'))
        ->tag('sourcekin.command_handler')

        // read models
        ->set(\Sourcekin\Content\Projection\DocumentReadModelXML::class)
        ->arg('$storageUrl', new Parameter('app.storage.xml'))
        ->set(\Sourcekin\Content\Projection\DocumentModelElasticSearch::class)


        // projectors
        ->set(\Sourcekin\Content\Projection\DocumentProjection::class)
        ->tag('sourcekin.projector', ['projection' => 'documents', 'read_model' => \Sourcekin\Content\Projection\DocumentModelElasticSearch::class])

    ;
};