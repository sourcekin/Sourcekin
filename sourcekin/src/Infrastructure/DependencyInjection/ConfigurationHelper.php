<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 06.06.18
 *
 */

namespace Sourcekin\Infrastructure\DependencyInjection;

class ConfigurationHelper
{
    public static function getPackageDir()
    {
        return dirname(dirname(__DIR__));
    }
}