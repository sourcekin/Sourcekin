<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 11.06.18
 *
 */

use Sourcekin\Domain\Persistence\ObjectStore;
use SourcekinBundle\Persistence\DoctrineObjectStore;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;

return function(ContainerConfigurator $container) {
    $container->services()->defaults()->autoconfigure()->autowire()
    ->set(DoctrineObjectStore::class)
    ->arg('$entityManager', new Reference('doctrine.orm.entity_manager'))
    ->alias(ObjectStore::class, DoctrineObjectStore::class);
};