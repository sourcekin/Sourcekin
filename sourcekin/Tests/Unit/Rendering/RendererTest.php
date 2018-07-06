<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 05.07.18.
 */

namespace Sourcekin\Tests\Unit\Rendering;


use PHPUnit\Framework\TestCase;
use Sourcekin\Components\Events\EventEmitter;
use Sourcekin\Components\Rendering\Control\ContentControl;
use Sourcekin\Components\Rendering\ControlCollection;
use Sourcekin\Components\Rendering\Model\Content;
use Sourcekin\Components\Rendering\Model\RenderingContext;
use Sourcekin\Components\Rendering\Renderer;
use Sourcekin\Components\Rendering\View\ContentView;

class ControlCollectionImpl implements ControlCollection {

    /**
     * @param $name
     *
     * @return bool
     */
    public function contains($name): bool {
        if ($name === 'text') {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * @param $name
     *
     * @return ContentControl
     */
    public function acquire($name): ContentControl {
        if ($name === 'text') {
            return new class implements ContentControl {

                /**
                 * @return ContentView
                 */
                public function createView(): ContentView {
                    return new ContentView();
                }

                /**
                 * @param $content
                 *
                 * @return $this
                 */
                public function withContent($content) {
                    $this->content = $content;

                    return $this;
                }

                /**
                 * @param Content          $content
                 * @param RenderingContext $context
                 */
                public function configure(Content $content, RenderingContext $context): void {
                    $context->set('configured', 'yes');
                }

                /**
                 * @param EventEmitter     $emitter
                 * @param RenderingContext $context
                 */
                public function process(EventEmitter $emitter, RenderingContext $context): void {
                    $context->set('processed', 'yes');
                }
            };
        }

        return NULL;
    }
}

class RendererTest extends TestCase {

    public function testRender() {

        $renderer = new Renderer(new ControlCollectionImpl());
        $context  = RenderingContext::blank();
        $result   = $renderer->render(Content::withType('text'), $context);
        $this->assertInstanceOf(ContentView::class, $result);

        $this->assertTrue($context->has('configured'));
        $this->assertEquals('yes', $context->get('configured')->content());
        $this->assertTrue($context->has('processed'));
        $this->assertEquals('yes', $context->get('processed')->content());
    }

}