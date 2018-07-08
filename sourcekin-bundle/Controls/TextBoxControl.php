<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 08.07.18.
 */

namespace SourcekinBundle\Controls;


use Sourcekin\Components\Rendering\Control\ContentControl;
use Sourcekin\Components\Rendering\Model\Content;
use Sourcekin\Components\Rendering\View\ContentView;

class TextBoxControl implements ContentControl {

    const NAME = 'textbox';
    /**
     * @param Content $content
     *
     * @return ContentView
     */
    public function createView(Content $content): ContentView {
        return ContentView::fromContent($content);
    }

    /** @return string */
    public function name(): string {
        return static::NAME;
    }

    /**
     * @return array
     */
    public function requires(): array {
        return [];
    }

}