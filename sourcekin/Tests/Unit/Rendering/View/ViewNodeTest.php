<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 08.07.18
 *
 */

namespace Sourcekin\Tests\Unit\Rendering\View;

use PHPUnit\Framework\TestCase;
use Sourcekin\Components\Rendering\View\ContentView;
use Sourcekin\Components\Rendering\View\ViewNode;

class ViewNodeTest extends TestCase
{

    public function testNesting()
    {
        $node = $this->makeNodes();

        $this->assertEquals('12345', (string)$node->id());
        $this->assertEquals(3, $node->count());

    }

    public function testToArraySortsByPosition()
    {
        $node  = $this->makeNodes();
        $array = $node->toArray();

        $this->assertArrayHasKey('children', $array);
        $this->assertCount(3, $array['children']);
        $this->assertEquals('9999', $array['children'][0]['id']);
        $this->assertEquals('555', $array['children'][1]['id']);
        $this->assertEquals('222', $array['children'][2]['id']);
    }

    public function testToString()
    {
        $string = $this->makeNodes()->toString();
        $this->assertNotEmpty($string);
        $json = json_decode($string);
        $this->assertInstanceOf(\stdClass::class, $json);

    }


    /**
     * @return ViewNode
     */
    protected function makeNodes(): ViewNode
    {
        $rootContent = ContentView::fromArray(
            [
                'id'         => '12345',
                'type'       => 'text',
                'attributes' => ['position' => 0],
            ]
        );
        $child1      = ContentView::fromArray(
            [
                'id'     => '9999',
                'parent' => '12345',
                'type'   => 'text',
            ]
        );
        $child2      = ContentView::fromArray(
            [
                'id'         => '222',
                'parent'     => '12345',
                'type'       => 'text',
                'attributes' => [
                    'position' => '3'
                ]
            ]
        );
        $child3      = ContentView::fromArray(
            [
                'id'         => '555',
                'parent'     => '12345',
                'type'       => 'text',
                'attributes' => [
                    'position' => '2'
                ]
            ]
        );

        $node = new ViewNode($rootContent);
        $node->addChild(ViewNode::fromView($child1))
             ->addChild(ViewNode::fromView($child2))
             ->addChild(ViewNode::fromView($child3))
        ;

        return $node;
    }


}