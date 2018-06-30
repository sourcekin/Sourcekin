<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 30.06.18
 *
 */

namespace SourcekinBundle\ServiceBus;

class QueryBus extends \Prooph\ServiceBus\QueryBus implements PluginAwareMessageBus
{
    use PluginCapabilities;
}