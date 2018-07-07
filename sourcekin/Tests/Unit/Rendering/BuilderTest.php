<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 05.07.18.
 */

namespace Sourcekin\Tests\Unit\Rendering;


use PHPUnit\Framework\TestCase;
use Sourcekin\Components\Rendering\ViewBuilder;


class BuilderTest extends TestCase {

    public function testRender() {

        $builder = new ViewBuilder(new ControlCollectionImpl());
        $this->assertInstanceOf(ViewBuilder::class, $builder);

    }


}