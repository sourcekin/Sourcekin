<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 15.06.18.
 */

namespace Sourcekin\User;


use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;

class UserRepository extends EventSourcingRepository {
    public function __construct(
        EventStore $eventStore,
        EventBus $eventBus,
        $eventStreamDecorators = []
    ) {
        parent::__construct(
            $eventStore,
            $eventBus,
            User::class,
            new PublicConstructorAggregateFactory(),
            $eventStreamDecorators
        );
    }


}