<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 06.07.18.
 */

namespace Sourcekin\Tests\Unit\Rendering;


use Sourcekin\Components\Rendering\Control\ContentControl;
use Sourcekin\Components\Rendering\ControlCollection;
use Sourcekin\Tests\Unit\Rendering\Control\InteractiveControlImpl;
use Sourcekin\Tests\Unit\Rendering\Control\TextControlImpl;

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
        if( $name === 'interactive') {
            return true;
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
            return new TextControlImpl();
        }

        if( $name === 'interactive') {
            return new InteractiveControlImpl();
        }

        return NULL;
    }
}