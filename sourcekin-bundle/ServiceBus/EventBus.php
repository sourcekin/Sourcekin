<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 20.06.18.
 */

namespace SourcekinBundle\ServiceBus;


class EventBus extends \Prooph\ServiceBus\EventBus implements PluginAwareMessageBus {

    use PluginCapabilities;

}