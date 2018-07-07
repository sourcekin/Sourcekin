<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 05.07.18.
 */

namespace Sourcekin\Components\Rendering\Control;


use Sourcekin\Components\Rendering\Model\Content;
use Sourcekin\Components\Rendering\View\ContentView;

interface ContentControl {

    /**
     * @param Content $content
     *
     * @return ContentView
     */
    public function createView(Content $content): ContentView;

    /** @return string */
    public function name(): string;

    /**
     * @return array
     */
    public function requires(): array;

}