<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 16.06.18
 *
 */

namespace SourcekinBundle\Util;

class CommandHelper
{
    public static function prefix($name)
    {
        return sprintf('sourcekin:%s', $name);
    }
}