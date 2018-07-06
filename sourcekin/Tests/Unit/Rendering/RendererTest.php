<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 05.07.18.
 */

namespace Sourcekin\Tests\Unit\Rendering;


use PHPUnit\Framework\TestCase;
use Sourcekin\Components\Rendering\ContentStream;
use Sourcekin\Components\Rendering\Model\Content;
use Sourcekin\Components\Rendering\Model\RenderingContext;
use Sourcekin\Components\Rendering\Renderer;
use Sourcekin\Components\Rendering\View\ContentView;


class RendererTest extends TestCase {

    public function testRender() {

        $renderer = new Renderer(new ControlCollectionImpl());
        $context  = RenderingContext::blank();
        $result   = $renderer->render(ContentStream::withContents(Content::withType('text')), $context);
        $this->assertInstanceOf(ContentView::class, $result);

    }


}