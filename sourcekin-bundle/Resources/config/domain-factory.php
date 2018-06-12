<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 11.06.18
 *
 */

use Sourcekin\Domain\Factory\DomainObjectFactory;
use Sourcekin\Domain\Factory\ReflectionFactory;
use SourcekinBundle\Factory\DoctrineMetaDateFactory;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;

return function (ContainerConfigurator $container) {

    $container
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->set(ReflectionFactory::class)
        ->set(DoctrineMetaDateFactory::class)
        ->arg('$metadataFactory', new Reference('doctrine.orm.default_entity_manager.metadata_factory'))
        ->set(DomainObjectFactory::class)
        ->arg('$factories', [ new Reference(DoctrineMetaDateFactory::class), new Reference(ReflectionFactory::class)])
        ->arg('$classMap', new Parameter('sourcekin.classmap'))
        ->alias('domain_factory', DomainObjectFactory::class);

};