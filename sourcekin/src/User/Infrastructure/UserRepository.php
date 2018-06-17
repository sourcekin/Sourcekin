<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 17.06.18.
 */

namespace Sourcekin\User\Infrastructure;


use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\StreamName;
use Prooph\SnapshotStore\SnapshotStore;
use Sourcekin\User\Model\User;
use Sourcekin\User\Model\UserRepository as GenericUserRepository;

class UserRepository extends AggregateRepository implements GenericUserRepository {


    /**
     * UserRepository constructor.
     */
    public function __construct(EventStore $eventStore, SnapshotStore $snapshotStore) {
        parent::__construct(
            $eventStore,
            AggregateType::fromAggregateRootClass(User::class),
            new AggregateTranslator(),
            $snapshotStore
        );
    }

    public function save(User $user): void {
        $this->saveAggregateRoot($user);
    }

    public function get(string $id): ?User {
        return $this->getAggregateRoot($id);
    }
}