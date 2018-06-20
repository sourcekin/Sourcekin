<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 20.06.18.
 */

namespace SourcekinBundle\ServiceBus;


use Prooph\ServiceBus\Plugin\Plugin;

trait PluginCapabilities {

    public function addPlugin(Plugin $plugin) {
        $plugin->attachToMessageBus($this);
    }

    public function removePlugin(Plugin $plugin) {
        $plugin->detachFromMessageBus($this);
    }
}