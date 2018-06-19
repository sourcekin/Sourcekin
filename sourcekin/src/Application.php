<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 09.06.18.
 */

namespace Sourcekin;


use Sourcekin\User\UserModule;

class Application {

    protected static $modules = [
        'user' => UserModule::class
    ];

    public static function path($relative) {
        return __DIR__.$relative;
    }

    public static function ns($namespace) {
        return str_replace('.', '\\', $namespace);
    }

    public static function addModule($name, $class) {
        static::$modules[$name] = $class;
    }

    public static function modules() {
        return static::$modules;
    }
}