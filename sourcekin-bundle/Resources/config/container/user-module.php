<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 20.06.18
 *
 */

use Sourcekin\User\Model\UserRepository;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;

return function (ContainerConfigurator $container) {
    $container
        ->services()->defaults()->autowire()->autoconfigure()->private()
        // repository
        ->set(\Sourcekin\User\Model\UserRepository::class, \Sourcekin\User\Infrastructure\UserRepository::class)

        // command handlers
        ->set(\Sourcekin\User\Model\Handler\Command\ChangeEmailHandler::class)
        ->tag('sourcekin.command_handler')
        ->set(\Sourcekin\User\Model\Handler\Command\RegisterUserHandler::class)
        ->tag('sourcekin.command_handler')
        ->set(\Sourcekin\User\Model\Handler\Command\SendRegistrationConfirmationHandler::class)
        ->tag('sourcekin.command_handler')

        // projectors
        ->set(\Sourcekin\User\Projection\UserProjector::class)
        ->tag('sourcekin.projector', ['projection' => 'users', 'read_model' => \Sourcekin\User\Projection\UserReadModel::class])
        ->set(\Sourcekin\User\Projection\UserSnapshotProjector::class)
        ->tag('sourcekin.projector', ['projection' => 'user_snapshots', 'read_model' => \Sourcekin\User\Projection\UserSnapshotModel::class])

        // finder
        ->set(\Sourcekin\User\Projection\UserFinder::class)

        // query handler
        ->set(\Sourcekin\User\Model\Handler\Query\GetUserByIdHandler::class)
        ->tag('sourcekin.query_handler')
        ->set(\Sourcekin\User\Model\Handler\Query\GetAllUsersHandler::class)
        ->tag('sourcekin.query_handler')

        // read models
        ->set(\Sourcekin\User\Projection\UserReadModel::class)

        ->set(\Sourcekin\User\Projection\UserSnapshotModel::class, \Prooph\Snapshotter\SnapshotReadModel::class)
        ->arg('$aggregateRepository', new Reference(UserRepository::class))
        ->arg('$aggregateTypes', [\Sourcekin\User\Model\User::class])

        ->set(\Sourcekin\User\ProcessManager\SendRegistrationConfirmationProcessManager::class)
        ->tag('sourcekin.event_handler')
        ;
};