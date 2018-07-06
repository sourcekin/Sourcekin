<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 06.07.18.
 */

namespace Sourcekin\Tests\Unit\Rendering\Control;


use Sourcekin\Components\Rendering\Control\ContentControl;
use Sourcekin\Components\Rendering\Model\Content;
use Sourcekin\Components\Rendering\Model\RenderingContext;
use Sourcekin\Components\Rendering\View\ContentView;
use Sourcekin\Components\Rendering\View\ProcessableView;

class InteractiveControlImpl implements ContentControl {

    /**
     * @return ContentView
     */
    public function createView(): ContentView {

        return new ProcessableView('user_input', function() {

        });


    }

    /**
     * @param Content          $content
     */
    public function configure(Content $content): void {

    }
}