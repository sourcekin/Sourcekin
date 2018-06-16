<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 16.06.18
 *
 */

use SourcekinBundle\ReadModel\User\LoginUser;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;

return function (ContainerConfigurator $configurator) {
    $configurator
        ->services()
        ->defaults()->autowire()->autoconfigure()
        ->set('sourcekin.login_user.repository', Broadway\Repository\Repository::class)
        ->factory([new Reference('broadway.read_model.repository_factory'), 'create'])
        ->args(['sourcekin.login_user', LoginUser::class, []])
        ->set(\SourcekinBundle\ReadModel\User\LoginUserProjector::class)
        ->arg('$repository', new Reference('sourcekin.login_user.repository'))
        ->tag('broadway.domain.event_listener')
    ;

};