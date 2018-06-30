<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 20.06.18
 *
 */

namespace SourcekinBundle\Factory;


use Prooph\ServiceBus\Plugin\Router\MessageBusRouterPlugin;
use Sourcekin\Components\ServiceBus\CommandBus;

class CommandBusFactory
{
    public function compose(MessageBusRouterPlugin $router)
    {
        $commandBus = new CommandBus();
        $commandBus->addPlugin($router);

        return $commandBus;
    }

}