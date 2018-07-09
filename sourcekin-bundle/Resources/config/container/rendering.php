<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 08.07.18.
 */

use Sourcekin\Components\Events\EventEmitter;
use Sourcekin\Components\Events\SourcekinEventEmitter;
use Sourcekin\Components\Rendering\Plugins\Logger;
use Sourcekin\Components\Rendering\Plugins\TwigRenderer;
use Sourcekin\Components\Rendering\Renderer;
use Sourcekin\Components\Rendering\ViewBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;

return function(ContainerConfigurator $container){

    $container->services()->defaults()->autowire()->autoconfigure()->private()
        ->set(\Sourcekin\Components\Rendering\ControlCollection::class, \SourcekinBundle\Rendering\ControlCollection::class)
        ->set(EventEmitter::class, SourcekinEventEmitter::class)
        ->set(ViewBuilder::class)

        ->set(Logger::class)
        ->tag('monolog.logger', ['channel' => 'rendering'])

        ->set(TwigRenderer::class)

        ->set(Renderer::class)
        ->call('addPlugin', [new Reference(Logger::class)])
        ->call('addPlugin', [new Reference(TwigRenderer::class)])

        ->set(\SourcekinBundle\Controls\DocumentControl::class)
        ->tag('sourcekin.control', ['alias' => \SourcekinBundle\Controls\DocumentControl::NAME])

        ->set(\SourcekinBundle\Controls\TextBoxControl::class)
        ->tag('sourcekin.control', ['alias' => \SourcekinBundle\Controls\TextBoxControl::NAME])

        ;

};