<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 30.06.18.
 */

namespace Sourcekin\Components\DependencyInjection;

use Prooph\EventStore\EventStore;
use Prooph\ServiceBus\Plugin\Plugin;

interface Dependencies
{

    /**
     * @return \PDO
     */
    public function pdo();


    /**
     * @return EventStore
     */
    public function store();

    /**
     * @return Plugin[]
     */
    public function eventBusPlugins();

    /**
     * @return Plugin[]
     */
    public function commandBusPlugins();

    /**
     * @return Plugin[]
     */
    public function queryBusPlugins();


}