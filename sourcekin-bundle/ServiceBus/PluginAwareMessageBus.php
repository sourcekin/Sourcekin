<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 20.06.18.
 */

namespace SourcekinBundle\ServiceBus;


use Prooph\ServiceBus\Plugin\Plugin;

interface PluginAwareMessageBus {
    public function addPlugin(Plugin $plugin);
}