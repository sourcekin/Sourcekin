<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 05.07.18.
 */

namespace Sourcekin\Components\Rendering\Exception;


use RuntimeException;

class ControlNotFound extends RuntimeException {

    public static function withType($name) {
        return new static(sprintf('Unable to find control for content type "%s".', $name));
    }
}