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
use Sourcekin\Components\Rendering\View\ContentType;

class ContentTest extends TestCase
{

    public function testFromArray()
    {
        $content = new Content(
            [
                'type'       => 'text',
                'fields'     => $fields = [
                    ['name' => 'field1', 'content' => 'some content']
                ],
                'attributes' =>  $attribs = [
                     ['name' => 'attr1', 'content' => 'attr-content']
                ],
            ]
        );

        $this->assertInstanceOf(Content::class, $content);
        $this->assertEquals('text', $content->type());
        $this->assertEquals($fields, $content->fields());
        $this->assertEquals($attribs, $content->attributes());
    }
}