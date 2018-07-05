<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 05.07.18.
 */

namespace Sourcekin\Components\Rendering;


use Sourcekin\Components\Rendering\Control\ContentControl;
use Sourcekin\Components\Rendering\Model\Content;

class GetControl extends RenderingEvent {

    /**
     * @var Content
     */
    protected $content;
    /**
     * @var ContentControl
     */
    protected $control;

    /**
     * GetControl constructor.
     *
     * @param Content        $content
     * @param ContentControl $control
     */
    public function __construct(Content $content, ContentControl $control = null) {
        $this->content = $content;
        $this->control = $control;
    }

    /**
     * @return ContentControl
     */
    public function getControl(): ContentControl {
        return $this->control;
    }

    /**
     * @param ContentControl $control
     *
     * @return $this
     */
    public function setControl($control) {
        $this->control = $control;
        return $this;
    }


    public function getName() {
        return RenderingEvents::CONTROL;
    }
}