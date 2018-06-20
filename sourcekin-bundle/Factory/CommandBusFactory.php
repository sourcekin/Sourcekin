<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 20.06.18
 *
 */

namespace SourcekinBundle\Factory;


use SourcekinBundle\ServiceBus\CommandBus;
use Prooph\ServiceBus\Plugin\Router\MessageBusRouterPlugin;

class CommandBusFactory
{
    public function compose(MessageBusRouterPlugin $router)
    {
        $commandBus = new CommandBus();
        $commandBus->addPlugin($router);

        return $commandBus;
    }

}