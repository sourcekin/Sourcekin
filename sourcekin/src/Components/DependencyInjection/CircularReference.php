<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 06.07.18.
 */

namespace Sourcekin\Components\DependencyInjection;


class CircularReference extends \RuntimeException {

    public static function forDependencies($one, $other) {
        return new static(sprintf('Circular dependency: %s -> %s', $one, $other));
    }
}