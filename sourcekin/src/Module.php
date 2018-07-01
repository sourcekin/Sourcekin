<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 21.06.18
 *
 */

namespace Sourcekin;

use Prooph\ServiceBus\Plugin\Router\CommandRouter;
use Prooph\ServiceBus\Plugin\Router\EventRouter;
use Prooph\ServiceBus\Plugin\Router\MessageBusRouterPlugin;
use Prooph\ServiceBus\Plugin\Router\QueryRouter;

abstract class Module
{

    const STREAM_NAME = '';

    public static function streamName()
    {
        return static::STREAM_NAME;
    }

    abstract static public function repositories();
    abstract static public function projections();
    abstract static public function eventRoutes();
    abstract static public function commandRoutes();
    abstract static public function queryRoutes();

    public function routeCommands(CommandRouter $router) {
        foreach (static::commandRoutes() as $command => $handler) {
            $router->route($command)->to($handler);
        }
    }

    public function routeEvents(EventRouter $router)
    {
        foreach (static::eventRoutes() as $event => $routes) {
            foreach ($routes as $route)
                $router->route($event)->to($route);
        }
    }

    public function routeQueries(QueryRouter $router)
    {
        foreach (static::queryRoutes() as $query => $handler) {
            $router->route($query)->to($handler);
        }
    }
}