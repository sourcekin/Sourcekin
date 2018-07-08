<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 26.06.18
 *
 */

namespace Sourcekin\Content\Projection;

use Prooph\Bundle\EventStore\Projection\ReadModelProjection;
use Prooph\EventStore\Projection\ReadModelProjector;
use Sourcekin\Content\ContentModule;
use Sourcekin\Content\Model\Event\ContentWasAdded;
use Sourcekin\Content\Model\Event\DocumentWasInitialized;
use Sourcekin\Content\Model\Event\FieldWasAdded;

/**
 * Class DocumentProjection
 * @method DocumentReadModelXML readModel()
 */
class DocumentProjection implements ReadModelProjection {

    public function project(ReadModelProjector $projector): ReadModelProjector {
        $projector
            ->fromStream(ContentModule::STREAM_NAME)
            ->when(
                [
                    DocumentWasInitialized::class => function ($state, DocumentWasInitialized $event) {
                        $model = $this->readModel();
                        $model->stack(
                            'insert',
                            [
                                'type'  => 'document',
                                'id'    => $event->aggregateId(),
                                'name'  => $event->name(),
                                'title' => $event->title(),
                                'text'  => $event->text(),
                            ]
                        );
                    },
                    ContentWasAdded::class        => function ($state, ContentWasAdded $event) {
                        $model = $this->readModel();
                        $model->stack(
                            'addContent',
                            [
                                'owner'  => $event->aggregateId(),
                                'id'     => $event->id(),
                                'index'  => $event->index(),
                                'type'   => $event->type(),
                                'parent' => $event->parent(),
                            ]
                        );
                    },
                    FieldWasAdded::class          => function ($state, FieldWasAdded $event) {
                        $model = $this->readModel();
                        $model->stack(
                            'addField',
                            [
                                'owner'   => $event->aggregateId(),
                                'id'      => $event->contentId(),
                                'name'    => $event->name(),
                                'type'    => $event->type(),
                                'content' => $event->value(),
                            ]
                        );
                    },
                ]
            )
        ;

        return $projector;
    }
}