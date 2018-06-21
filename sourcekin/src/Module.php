<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 21.06.18
 *
 */

namespace Sourcekin;

abstract class Module
{

    const STREAM_NAME = '';

    public static function streamName()
    {
        return static::STREAM_NAME;
    }

    abstract static public function repositories();
    abstract static public function projections();
    abstract static public function eventRoutes();
}