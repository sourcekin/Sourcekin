<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 05.07.18.
 */

namespace Sourcekin\Tests\Unit\Events;


use PHPUnit\Framework\TestCase;
use Sourcekin\Components\Events\Event;
use Sourcekin\Components\Events\SourcekinEventEmitter;

class SomethingHappened extends Event {

    public $names = [];

    public function register($name) {
        $this->names[] = $name;
    }



    public function getName() {
        return 'something.happened';
    }
}

class SourcekinEventEmitterTest extends TestCase {

    public function testDispatch() {
        $emitter = new SourcekinEventEmitter();
        $handler1 = $emitter->attach('something.happened', function(SomethingHappened $event){ $event->register('listener1');}, 9);
        $handler2 = $emitter->attach('something.happened', function(SomethingHappened $event){ $event->register('listener2');}, 2);
        $handler3 = $emitter->attach('something.happened', function(SomethingHappened $event){ $event->register('listener3');}, 5);
        $handler4 = $emitter->attach('something.else', function(){});

        $event = new SomethingHappened();
        $emitter->dispatch($event);

        $this->assertCount(3, $event->names);
        $this->assertEquals(['listener1', 'listener3', 'listener2'], $event->names);

        $emitter->detach($handler3);
        $event = new SomethingHappened();
        $emitter->dispatch($event);
        $this->assertEquals(['listener1', 'listener2'], $event->names);

    }
}