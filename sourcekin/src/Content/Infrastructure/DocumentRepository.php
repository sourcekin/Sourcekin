<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 21.06.18
 *
 */

namespace Sourcekin\Content\Infrastructure;

use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\StreamName;
use Prooph\SnapshotStore\SnapshotStore;
use Sourcekin\Content\ContentModule;
use Sourcekin\Content\Model\Document;
use Sourcekin\Content\Model\DocumentRepository as GenericDocumentRepository;

class DocumentRepository extends AggregateRepository implements GenericDocumentRepository
{

    public function __construct(EventStore $eventStore, SnapshotStore $snapshotStore)
    {
        parent::__construct(
            $eventStore,
            AggregateType::fromAggregateRootClass(Document::class),
            new AggregateTranslator(),
            $snapshotStore,
            new StreamName(ContentModule::STREAM_NAME),
            false
        );
    }

    public function save(Document $document): void
    {
        $this->saveAggregateRoot($document);
    }

    public function get(string $id): ?Document
    {
        return $this->getAggregateRoot($id);
    }
}