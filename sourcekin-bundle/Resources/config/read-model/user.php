<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 16.06.18
 *
 */

use SourcekinBundle\ReadModel\Doctrine\ORM\ProjectionRepository;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;

return function (ContainerConfigurator $configurator) {
    $configurator
        ->services()
        ->defaults()->autowire()->autoconfigure()->private()
        // login user
        ->set('sourcekin.login_user.projection_repository', ProjectionRepository::class)
        ->arg('$className', \SourcekinBundle\ReadModel\User\SecurityUser::class)
        ->set(\SourcekinBundle\ReadModel\User\SecurityUserProjector::class)
        ->arg('$repository', new Reference('sourcekin.login_user.projection_repository'))
        ->tag('broadway.domain.event_listener')

        // screen user
        ->set('sourcekin.screen_user.projection_repository', \Broadway\ReadModel\Repository::class)
        ->factory([new Reference('broadway.read_model.repository_factory'), 'create' ])
        ->args(['sourcekin.screen_user', \Sourcekin\User\ReadModel\ScreenUser::class, []])
        ->set(\Sourcekin\User\ReadModel\ScreenUserProjector::class)
        ->arg('$repository', new Reference('sourcekin.screen_user.projection_repository'))
        ->tag('broadway.domain.event_listener')

        // screen use provider


    ;

};