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
     * @param Content $content
     *
     * @return ContentView
     */
    public function createView(Content $content): ContentView {

        return new ProcessableView('user_input', function() {

        });


    }


}