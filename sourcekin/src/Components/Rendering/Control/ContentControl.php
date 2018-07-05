<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 05.07.18.
 */

namespace Sourcekin\Components\Rendering\Control;


use Sourcekin\Components\Rendering\View\ContentView;

interface ContentControl {

    /**
     * @return ContentView
     */
    public function createView() : ContentView;

    /**
     * @param $content
     *
     * @return $this
     */
    public function withContent($content);

}