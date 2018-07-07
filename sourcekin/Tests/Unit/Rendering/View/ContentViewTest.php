<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 07.07.18.
 */

namespace Sourcekin\Tests\Unit\Rendering\View;


use PHPUnit\Framework\TestCase;
use Sourcekin\Components\Common\HashMap;
use Sourcekin\Components\Rendering\View\ContentId;
use Sourcekin\Components\Rendering\View\ContentType;
use Sourcekin\Components\Rendering\View\ContentView;

class ContentViewTest extends TestCase {

    public function testInstantiation() {
        $view = ContentView::fromData(ContentId::fromString('123'));
        $this->assertInstanceOf(ContentView::class, $view);
        $this->assertInstanceOf(ContentId::class, $view->id());
        $this->assertInstanceOf(ContentType::class, $view->type());
        $this->assertInstanceOf(HashMap::class, $view->attributes());
        $this->assertInstanceOf(HashMap::class, $view->vars());
    }

    public function testFromArray() {

        $input = [
            'id'         => '123999',
            'parent'     => '999555',
            'type'       => 'image',
            'attributes' => [
                'class' => 'some-class',
            ],
            'vars'       => [
                'text_left'  => 'this is text left',
                'text_right' => 'this is text right',
            ],
        ];

        $view = ContentView::fromArray($input);
        $this->assertInstanceOf(ContentView::class, $view);

        $this->assertEquals('123999', $view->id()->toString());
        $this->assertEquals('image', $view->type()->toString());
        $this->assertEquals('some-class', $view->attributes()->get('class'));
        $this->assertEquals('this is text left', $view->vars()->get('text_left'));
        $this->assertEquals('this is text right', $view->vars()->get('text_right'));

        $this->assertEquals($input, $view->toArray());

    }




}