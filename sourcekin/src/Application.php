<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 09.06.18.
 */

namespace Sourcekin;


class Application {

    public static function path($relative) {
        return __DIR__.$relative;
    }

    public static function ns($namespace) {
        return  str_replace('.', '\\', $namespace);
    }
}