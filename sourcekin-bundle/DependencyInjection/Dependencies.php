<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 01.07.18
 *
 */

namespace SourcekinBundle\DependencyInjection;

use Prooph\EventSourcing\Aggregate\AggregateTranslator;
use Prooph\EventStore\EventStore;
use Prooph\ServiceBus\Plugin\Plugin;
use Prooph\ServiceBus\Plugin\Router\CommandRouter;
use Prooph\ServiceBus\Plugin\Router\EventRouter;
use Prooph\ServiceBus\Plugin\Router\QueryRouter;
use Sourcekin\Components\DependencyInjection\Dependencies as SourcekinDependencies;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\Form\Tests\Fixtures\Type;

class Dependencies extends ServiceLocator implements SourcekinDependencies
{

    const PDO              = 'doctrine.pdo.connection';
    const EVENT_STORE      = 'sourcekin.event_store.inner';
    const TYPE_EVENT_BUS   = 'event_bus';
    const TYPE_COMMAND_BUS = 'command_bus';
    const TYPE_QUERY_BUS   = 'query_bus';

    protected $plugins = [
        self::TYPE_EVENT_BUS   => [],
        self::TYPE_QUERY_BUS   => [],
        self::TYPE_COMMAND_BUS => [],
    ];


    protected $queryRouter;

    protected $store;

    protected $commandRouter;

    /**
     * @param array $plugins
     *
     * @return $this
     */
    public function setPlugins($plugins)
    {
        $this->plugins = $plugins;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function commandBusPlugins()
    {
        foreach ($this->plugins[self::TYPE_COMMAND_BUS] as $commandBusPlugin) {
            yield $this->get($commandBusPlugin);
        }
    }


    /**
     * @inheritdoc
     */
    public function eventBusPlugins()
    {
        foreach ($this->plugins[self::TYPE_EVENT_BUS] as $eventBusPlugin) {
            yield $this->get($eventBusPlugin);
        }
    }


    /**
     * @inheritdoc
     */
    public function pdo()
    {
        return $this->get(self::PDO);
    }

    /**
     * @inheritdoc
     */
    public function queryBusPlugins()
    {
        foreach ($this->plugins[self::TYPE_QUERY_BUS] as $queryBusPlugin) {
            yield $this->get($queryBusPlugin);
        }
    }

    /**
     * @return EventStore
     */
    public function store()
    {
        if (!$this->store) {
            $this->store = $this->get(static::EVENT_STORE);
        }

        return $this->store;
    }
}