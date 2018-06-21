<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 21.06.18
 *
 */

namespace Sourcekin\Content\Model;

use Prooph\EventSourcing\AggregateRoot;
use Sourcekin\Components\ApplyEventCapabilities;
use Sourcekin\Content\Model\Event\DocumentWasInitialized;

class Document extends AggregateRoot
{
    use ApplyEventCapabilities;

    private $id;

    private $name;

    private $title;

    private $metaData;

    private $content;

    protected function aggregateId(): string
    {
        return $this->id;
    }

    public static function initialize($id, $name, $title, $content)
    {
        $obj = new self;
        $obj->recordThat(DocumentWasInitialized::occur($id, ['name' => $name, 'title' => $title, 'content' => $content]));

        return $obj;
    }

    public function onDocumentWasInitialized(DocumentWasInitialized $event)
    {
        $this->id      = $event->aggregateId();
        $this->title   = $event->title();
        $this->name    = $event->name();
        $this->content = $event->content();
    }
}