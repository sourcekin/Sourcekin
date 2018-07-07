<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 07.07.18.
 */

namespace Sourcekin\Tests\Unit\Common;


use PHPUnit\Framework\TestCase;
use Sourcekin\Components\Common\HashMap;

class HashMapTest extends TestCase {


    public function testInstantiation() {
        $this->assertInstanceOf(HashMap::class, HashMap::fromArray(['key' => 'value']));
        $this->assertInstanceOf(HashMap::class, HashMap::blank());
    }

    public function testArrayBehavior() {
        $elements = ['key' => 'value', 'array_value' => [], 'object_value' => new \stdClass()];
        $map = HashMap::fromArray($elements);

        $this->assertCount(3, $map);
        foreach ($elements as $key => $value) {
            $this->assertTrue($map->has($key));
            $this->assertEquals($value, $map->get($key));

            $map->remove($key);
            $this->assertFalse($map->has($key));
        }





    }
}