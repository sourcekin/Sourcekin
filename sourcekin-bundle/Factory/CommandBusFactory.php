<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 20.06.18
 *
 */

namespace SourcekinBundle\Factory;

use Prooph\ServiceBus\CommandBus;
use Prooph\ServiceBus\Plugin\Router\CommandRouter;
use Prooph\ServiceBus\Plugin\Router\MessageBusRouterPlugin;

class CommandBusFactory
{
    public function compose(MessageBusRouterPlugin $router)
    {
        $commandBus = new CommandBus();
        $router->attachToMessageBus($commandBus);
        return $commandBus;
    }

}