<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 19.06.18
 *
 */

namespace Sourcekin\User\Projection;

use Prooph\Bundle\EventStore\Projection\Projection;
use Prooph\Bundle\EventStore\Projection\ReadModelProjection;
use Prooph\Common\Messaging\Message;
use Prooph\EventStore\Projection\ProjectionManager;
use Prooph\EventStore\Projection\ReadModelProjector;
use Sourcekin\User\Model\User;
use Sourcekin\User\UserModule;

class UserSnapshotProjector implements ReadModelProjection {


    public function project(ReadModelProjector $projector): ReadModelProjector
    {
        $projector
            ->fromStream(UserModule::STREAM_NAME)
            ->whenAny(function ($state, Message $event): void {
                $this->readModel()->stack('replay', $event);
            });

        return $projector;
    }
}