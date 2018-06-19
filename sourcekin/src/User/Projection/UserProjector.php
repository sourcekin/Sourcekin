<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 17.06.18.
 */

namespace Sourcekin\User\Projection;


use Doctrine\DBAL\Connection;
use Prooph\Bundle\EventStore\Projection\Projection;
use Prooph\Bundle\EventStore\Projection\ReadModelProjection;
use Prooph\EventStore\Projection\ReadModelProjector;
use Sourcekin\User\Model\Event\EmailChanged;
use Sourcekin\User\Model\Event\UserRegistered;
use Sourcekin\User\Model\User;
use Sourcekin\User\UserModule;

/**
 * Class UserProjector
 * @method UserReadModel readModel()
 */
class UserProjector implements ReadModelProjection {

    public function project(ReadModelProjector $projector): ReadModelProjector
    {
        $projector
            ->fromStream(UserModule::STREAM_NAME)
            ->when([
                UserRegistered::class => function($state, UserRegistered $event){
                    $model = $this->readModel();
                    $model->stack('insert', [
                        'email'    => $event->email(),
                        'password' => $event->password(),
                        'username' => $event->username(),
                        'id'       => $event->aggregateId(),
                    ]);
                },
                EmailChanged::class => function($state, EmailChanged $event ){
                    $model = $this->readModel();
                    $model->stack('changeEmail', [
                        'email' => $event->email(),
                        'id' => $event->aggregateId()
                    ]);
                }
            ]);

        return $projector;
    }

}