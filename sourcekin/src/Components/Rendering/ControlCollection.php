<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 05.07.18.
 */

namespace Sourcekin\Components\Rendering;


use Sourcekin\Components\Rendering\Control\ContentControl;

interface ControlCollection {
    /**
     * @param $name
     *
     * @return bool
     */
    public function contains($name) : bool;

    /**
     * @param $name
     *
     * @return ContentControl
     */
    public function acquire($name) : ContentControl;

}