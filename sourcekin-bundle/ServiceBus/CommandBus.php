<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 20.06.18.
 */

namespace SourcekinBundle\ServiceBus;


class CommandBus extends \Prooph\ServiceBus\CommandBus implements PluginAwareMessageBus {

    use PluginCapabilities;
}