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
use Sourcekin\Components\EventSourcing\ApplyEventCapabilities;
use Sourcekin\Content\Model\Event\ContentWasAdded;
use Sourcekin\Content\Model\Event\DocumentWasInitialized;
use Sourcekin\Content\Model\Event\FieldWasAdded;

/**
 * Class Document
 */
class Document extends AggregateRoot {
    use  ApplyEventCapabilities;

    /**
     * @var DocumentId
     */
    private $id;

    /**
     * @var DocumentName
     */
    private $name;

    /**
     * @var DocumentTitle
     */
    private $title;

    /**
     * @var
     */
    private $metaData;

    /**
     * @var DocumentText
     */
    private $text;

    /**
     * @var Content[]
     */
    private $elements = [];

    /**
     * @return string
     */
    public function id() {
        return $this->aggregateId();
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getText() {
        return $this->text;
    }

    /**
     * @return Content[]
     * @todo: this should be a collection of value object
     */
    public function getElements(): array {
        return $this->elements;
    }


    /**
     * @param $id
     * @param $name
     * @param $type
     * @param $index
     * @param $parent
     */
    public function addContent($id, $name, $type, $index, $parent) {
        if (!($parent === $this->aggregateId())) {
            if (!array_key_exists($parent, $this->elements)) {
                throw new \InvalidArgumentException(sprintf('Parent %s is invalid.', $parent));
            }
        }

        if (array_key_exists($id, $this->elements)) {
            throw new \InvalidArgumentException(sprintf('Duplicate content #%s.', $id));
        }

        $this->recordThat(
            ContentWasAdded::occur(
                $this->aggregateId(),
                [
                    'id'     => $id,
                    'type'   => $type,
                    'index'  => $index,
                    'parent' => $parent,
                    'name'   => $name
                ]
            )
        );
    }

    /**
     * @param $contentId
     * @param $name
     * @param $value
     * @param $type
     */
    public function addField($contentId, $name, $value, $type, $index = null) {
        if (!($content = $this->elements[$contentId] ?? NULL)) {
            throw new \InvalidArgumentException(sprintf('Content %s not found.', $contentId));
        }

        if ($content->containsField($name)) {
            throw new \InvalidArgumentException(sprintf('Duplicate field %s.', $name));
        }

        $this->recordThat(
            FieldWasAdded::occur(
                $this->aggregateId(),
                [
                    'content_id' => $contentId,
                    'name'       => $name,
                    'value'      => $value,
                    'type'       => $type,
                    'index'      => $index
                ]
            )
        );

    }

    /**
     * @param $name
     * @param $title
     * @param $text
     *
     * @return Document
     */
    public static function initialize($name, $title, $text) {
        $obj = new self;
        $obj->recordThat(
            DocumentWasInitialized::occur(
                DocumentId::generate()->toString(),
                ['name' => $name, 'title' => $title, 'text' => $text]
            )
        );

        return $obj;
    }

    /**
     * @param DocumentWasInitialized $event
     */
    public function onDocumentWasInitialized(DocumentWasInitialized $event) {
        $this->id    = DocumentId::fromString($event->aggregateId());
        $this->title = DocumentTitle::fromString( $event->title());
        $this->name  = DocumentName::fromString($event->name());
        $this->text  = DocumentText::fromString($event->text());
    }

    /**
     * @param ContentWasAdded $event
     */
    public function onContentWasAdded(ContentWasAdded $event) {
        $content = Content::fromArray(
            [
                'id'     => $event->id(),
                'parent' => $event->parent(),
                'index'  => $event->index(),
                'type'   => $event->type(),
                'owner'  => $this->aggregateId(),
                'name'   => $event->name()
            ]
        );

        $this->elements[(string)$content->id()] = $content;
    }

    /**
     * @param FieldWasAdded $event
     */
    public function onFieldWasAdded(FieldWasAdded $event) {
        $content = $this->elements[$event->contentId()];
        $content->addField(
            Field::fromArray(
                [
                    'key'   => $event->name(),
                    'value' => $event->value(),
                    'type'  => $event->type(),
                    'index' => $event->index() ?? count($content->fields())
                ]
            )
        );
    }

    /**
     * @return string
     */
    protected function aggregateId(): string {
        return $this->id;
    }
}