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
use Sourcekin\Content\Model\Event\ContentWasAdded;
use Sourcekin\Content\Model\Event\DocumentWasInitialized;

class Document extends AggregateRoot
{
    use ApplyEventCapabilities;

    private $id;

    private $name;

    private $title;

    private $metaData;

    private $text;

    /**
     * @var Content[]
     */
    private $elements = [];

    public function addContent($identifier, $type, $index, $parent) {

        if( ! $parent = $this->elements[$parent]??null) {
            throw new \InvalidArgumentException('parent not found');
        }

        if( $item = $this->elements[$identifier]??null){
            throw new \InvalidArgumentException('identifier must be unique');
        }

        $this->recordThat(ContentWasAdded::occur($this->aggregateId(), [
            'identifier' => $identifier,
            'type'       => $type,
            'index'      => $index,
            'parent'     => $parent
        ]));
    }

    protected function aggregateId(): string
    {
        return $this->id;
    }

    public static function initialize($id, $name, $title, $text)
    {
        $obj = new self;
        $obj->recordThat(DocumentWasInitialized::occur($id, ['name' => $name, 'title' => $title, 'text' => $text]));

        return $obj;
    }



    public function onDocumentWasInitialized(DocumentWasInitialized $event)
    {
        $this->id    = $event->aggregateId();
        $this->title = $event->title();
        $this->name  = $event->name();
        $this->text  = $event->text();
    }

    public function onContentWasAdded(ContentWasAdded $event) {
        $content = $event->content();
        $this->elements[$event->parent()]->add($content);


    }
}