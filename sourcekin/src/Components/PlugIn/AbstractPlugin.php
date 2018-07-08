<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 08.07.18
 *
 */

namespace Sourcekin\Components\PlugIn;

abstract  class AbstractPlugin implements Plugin
{
    /**
     * @var array
     */
    protected $listenerHandlers = [];

    public function unsubscribe(SupportsPlugins $subject)
    {
        foreach ($this->listenerHandlers as $handler) $subject->detach($handler);
        $this->listenerHandlers = [];
    }


}