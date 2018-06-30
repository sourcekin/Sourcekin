<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 19.06.18
 *
 */

namespace Sourcekin\User;

use Sourcekin\Module;
use Sourcekin\User\Infrastructure\UserRepository;
use Sourcekin\User\Model\Event\UserRegistered;
use Sourcekin\User\Model\User;
use Sourcekin\User\ProcessManager\SendRegistrationConfirmationProcessManager;
use Sourcekin\User\Projection\UserProjector;
use Sourcekin\User\Projection\UserReadModel;
use Sourcekin\User\Projection\UserSnapshotModel;
use Sourcekin\User\Projection\UserSnapshotProjector;

class UserModule extends Module
{
    const STREAM_NAME = 'user_events';

    public static function repositories()
    {
        return [
            'user_collection' => [
                'repository_class' => UserRepository::class,
                'aggregate_type'   => User::class
            ]
        ];
    }

    public static function projections()
    {
        return [
            'users' => [
                'read_model' => UserReadModel::class,
                'projection' => UserProjector::class
            ],
            'user_snapshot' => [
                'read_model' => UserSnapshotModel::class,
                'projection' => UserSnapshotProjector::class
            ]
        ];
    }

    public static function eventRoutes() {
        return [
            UserRegistered::class => [
                SendRegistrationConfirmationProcessManager::class
            ]
        ];
    }

}