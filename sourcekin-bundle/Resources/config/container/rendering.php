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
        ->set(\SourcekinBundle\Rendering\ControlCollection::class)
        ->set(\SourcekinBundle\Rendering\TimedControlCollection::class)
        ->arg('$collection', new Reference(\SourcekinBundle\Rendering\ControlCollection::class))
        ->alias(\Sourcekin\Components\Rendering\ControlCollection::class, \SourcekinBundle\Rendering\TimedControlCollection::class)

        ->set(EventEmitter::class, SourcekinEventEmitter::class)
        ->set(ViewBuilder::class)

        ->set(Logger::class)
        ->tag('monolog.logger', ['channel' => 'rendering'])

        ->set(TwigRenderer::class)
        ->set(\SourcekinBundle\Rendering\Plugin\StopWatchPlugin::class)

        ->set(\SourcekinBundle\Rendering\Plugin\ViewCachePlugin::class)
        ->arg('$adapter', new Reference('app.cache.document'))

        ->set(Renderer::class)
        ->call('addPlugin', [new Reference(\SourcekinBundle\Rendering\Plugin\ViewCachePlugin::class)])
        ->call('addPlugin', [new Reference(Logger::class)])
        ->call('addPlugin', [new Reference(TwigRenderer::class)])
        ->call('addPlugin', [new Reference(\SourcekinBundle\Rendering\Plugin\StopWatchPlugin::class)])

        ->set(\SourcekinBundle\Controls\DocumentControl::class)
        ->tag('sourcekin.control', ['alias' => \SourcekinBundle\Controls\DocumentControl::NAME])

        ->set(\SourcekinBundle\Controls\TextBoxControl::class)
        ->tag('sourcekin.control', ['alias' => \SourcekinBundle\Controls\TextBoxControl::NAME])

        ;

};