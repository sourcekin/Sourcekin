<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 06.07.18
 *
 */

namespace Sourcekin\Tests\Unit\Rendering\Model;

use PHPUnit\Framework\TestCase;
use Sourcekin\Components\Rendering\Model\Content;
use Sourcekin\Components\Rendering\Model\ContentType;

class ContentTest extends TestCase
{

    public function testFromArray()
    {
        $content = Content::fromArray(
            [
                'type'       => 'text',
                'fields'     => [
                    ['name' => 'field1', 'content' => 'some content']
                ],
                'attributes' => [
                    ['name' => 'attr1', 'content' => 'attr-content']
                ],
            ]
        );

        $this->assertInstanceOf(Content::class, $content);
        $this->assertInstanceOf(ContentType::class, $content->type());
    }
}