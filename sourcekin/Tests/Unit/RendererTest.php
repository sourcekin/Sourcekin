<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 05.07.18.
 */

namespace Sourcekin\Tests\Unit;


use PHPUnit\Framework\TestCase;
use Sourcekin\Components\Events\EventHandler;
use Sourcekin\Components\Events\IEvent;
use Sourcekin\Components\Events\SourcekinEventDispatcher;
use Sourcekin\Components\Rendering\Model\Content;
use Sourcekin\Components\Rendering\Renderer;
use Sourcekin\Components\Rendering\RenderingEvent;
use Sourcekin\Components\Rendering\Views\ContentView;

class RendererTest extends TestCase {

    public function testRender() {

        $renderer    = new Renderer();




        $result   = $renderer->render(new Content());
        $this->assertInstanceOf(ContentView::class, $result);

    }

}