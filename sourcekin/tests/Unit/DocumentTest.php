<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 26.06.18
 *
 */

namespace Sourcekin\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Prooph\EventSourcing\EventStoreIntegration\AggregateRootDecorator;
use Ramsey\Uuid\Uuid;
use Sourcekin\Content\Model\Document;
use Sourcekin\Content\Model\Event\ContentWasAdded;
use Sourcekin\Content\Model\Event\DocumentWasInitialized;
use Sourcekin\Content\Model\Event\FieldWasAdded;
use Sourcekin\Content\Model\Field;

class DocumentTest extends TestCase
{

    public function testEventSourcing()
    {
        $decorator = AggregateRootDecorator::newInstance();
        $document  = Document::initialize('my document', 'document title', '');
        $aggregateId = $document->id();
        $events      = [
            ContentWasAdded::occur($aggregateId, [
                'index'      => 1,
                'parent'     => null,
                'type'       => 'textbox',
                'identifier' => 'my_textbox_1',
            ]),
            FieldWasAdded::occur($aggregateId, [
                'content_id' => 'my_textbox_1',
                'name'       => 'text',
                'value'      => 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Curabitur luctus lacus eros. Mauris tortor lacus, condimentum nec eleifend in, aliquet ut metus. Sed varius tellus vitae nisi congue eu fringilla tellus aliquet. Nulla suscipit porttitor velit, id lobortis orci congue at. Nunc a dolor nulla. Integer quis dignissim ante. ',
                'type'       => 'text',
            ]),
            ContentWasAdded::occur($aggregateId, [
                'index' => 9,
                'parent' => 'my_textbox_1',
                'type' => 'image',
                'identifier' => 'my_image_1'
            ]),
            FieldWasAdded::occur($aggregateId, [
                'content_id' => 'my_image_1',
                'name'       => 'fancy image',
                'value'      => '',
                'type'       => 'image'
            ])
        ];

        $decorator->replayStreamEvents($document, new \ArrayIterator($events));

        $this->assertEquals('my document', $document->getName());
        $this->assertEquals('document title', $document->getTitle());

    }

}