<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 21.06.18
 *
 */

namespace Sourcekin\Content\Model;

use Prooph\EventSourcing\AggregateRoot;
use Ramsey\Uuid\Uuid;
use Sourcekin\Components\ApplyEventCapabilities;
use Sourcekin\Content\Model\Event\ContentWasAdded;
use Sourcekin\Content\Model\Event\DocumentWasInitialized;
use Sourcekin\Content\Model\Event\FieldWasAdded;

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

    public function id()
    {
        return $this->aggregateId();
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return Content[]
     * @todo: this should be a collection of value object
     */
    public function getElements(): array
    {
        return $this->elements;
    }


    public function addContent($identifier, $type, $index, $parent)
    {
        if( ! ($parent === $this->aggregateId())) {
            if( ! array_key_exists($parent, $this->elements)) {
                throw new \InvalidArgumentException(sprintf('Parent %s is invalid.', $parent));
            }
        }

        if(array_key_exists($identifier, $this->elements)) {
            throw new \InvalidArgumentException(sprintf('Duplicate content #%s.', $identifier));
        }

        $this->recordThat(
            ContentWasAdded::occur(
                $this->aggregateId(),
                [
                    'identifier' => $identifier,
                    'type'       => $type,
                    'index'      => $index,
                    'parent'     => $parent,
                ]
            )
        );
    }

    public function addField($contentId, $name, $value, $type)
    {
        if( ! ($content = $this->elements[$contentId]??null)) {
            throw new \InvalidArgumentException(sprintf('Content %s not found.', $contentId));
        }

        if( $content->containsField($name)) {
            throw new \InvalidArgumentException(sprintf('Duplicate field %s.', $name));
        }

        $this->recordThat(FieldWasAdded::occur($this->aggregateId(), [
            'content_id' => $contentId,
            'name'       => $name,
            'value'      => $value,
            'type'       => $type,
        ]));

    }

    public static function initialize($name, $title, $text)
    {
        $obj = new self;
        $obj->recordThat(DocumentWasInitialized::occur(Uuid::uuid4()->toString(), ['name' => $name, 'title' => $title, 'text' => $text]));

        return $obj;
    }

    public function onDocumentWasInitialized(DocumentWasInitialized $event)
    {
        $this->id                  = $event->aggregateId();
        $this->title               = $event->title();
        $this->name                = $event->name();
        $this->text                = $event->text();
    }

    public function onContentWasAdded(ContentWasAdded $event)
    {
        $content = Content::from($event->identifier(), $event->type(), $event->index());
        $this->elements[$content->getIdentifier()] = $content;
    }

    public function onFieldWasAdded(FieldWasAdded $event)
    {
        $content = $this->elements[$event->contentId()];
        $content->addField($event->name(), $event->value(), $event->type());
    }

    protected function aggregateId(): string
    {
        return $this->id;
    }
}