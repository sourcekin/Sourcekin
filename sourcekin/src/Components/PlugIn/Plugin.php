<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 06.07.18.
 */

namespace Sourcekin\Components\Plugin;


use Sourcekin\Components\Plugin\SupportsPlugins;

interface Plugin {

    /**
     * @param SupportsPlugins $subject
     */
    public function subscribe(SupportsPlugins $subject);

    /**
     * @param SupportsPlugins $subject
     */
    public function unsubscribe(SupportsPlugins $subject);

}