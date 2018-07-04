<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 09.06.18.
 */

namespace Sourcekin;

use Prooph\Common\Event\ProophActionEventEmitter;
use Prooph\EventStore\ActionEventEmitterEventStore;
use Prooph\EventStore\EventStore;
use Prooph\EventStoreBusBridge\EventPublisher;
use Prooph\ServiceBus\Plugin\Router\CommandRouter;
use Prooph\ServiceBus\Plugin\Router\EventRouter;
use Prooph\ServiceBus\Plugin\Router\QueryRouter;
use Sourcekin\Components\DependencyInjection\Dependencies;
use Sourcekin\Components\ServiceBus\CommandBus;
use Sourcekin\Components\ServiceBus\EventBus;
use Sourcekin\Components\ServiceBus\QueryBus;
use Sourcekin\Content\ContentModule;
use Sourcekin\User\UserModule;

class Application
{

    protected static $modules = [
        'user'    => UserModule::class,
        'content' => ContentModule::class,
    ];

    /**
     * @var bool
     */
    protected $initialized = false;

    /**
     * @var EventRouter
     */
    protected $eventRouter;

    /**
     * @var CommandRouter
     */
    protected $commandRouter;

    /**
     * @var QueryRouter
     */
    protected $queryRouter;

    /**
     * @var Dependencies
     */
    private $dependencies;

    /**
     * @var EventStore
     */
    private $eventStore;

    /**
     * @var EventBus
     */
    private $eventBus;

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var QueryBus
     */
    private $queryBus;

    /**
     * Application constructor.
     *
     * @param Dependencies $dependencies
     */
    public function __construct(Dependencies $dependencies)
    {
        $this->dependencies = $dependencies;
    }

    public static function path($relative)
    {
        return __DIR__.$relative;
    }

    public static function ns($namespace)
    {
        return str_replace('.', '\\', $namespace);
    }

    public static function addModule($name, $class)
    {
        static::$modules[$name] = $class;
    }

    /**
     * @return Module[]
     */
    public static function modules()
    {
        return static::$modules;
    }

    public function initialize()
    {
        if (!$this->initialized) {
            $dependencies      = $this->dependencies;
            $emitter           = new ProophActionEventEmitter();
            $this->eventStore  = new ActionEventEmitterEventStore($dependencies->store(), $emitter);
            $this->eventBus    = new EventBus($emitter);
            $this->eventRouter = new EventRouter();
            $publisher         = new EventPublisher($this->eventBus);
            $publisher->attachToEventStore($this->eventStore);
            $this->eventBus->addPlugin($this->eventRouter);
            foreach ($dependencies->eventBusPlugins() as $eventBusPlugin) {
                $this->eventBus->addPlugin($eventBusPlugin);
            }

            $this->commandRouter = new CommandRouter();
            $this->commandBus    = new CommandBus();
            $this->commandBus->addPlugin($this->commandRouter);
            foreach ($dependencies->commandBusPlugins() as $commandBusPlugin) {
                $this->commandBus->addPlugin($commandBusPlugin);
            }

            $this->queryRouter = new QueryRouter();
            $this->queryBus    = new QueryBus();
            $this->queryBus->addPlugin($this->queryRouter);
            foreach ($dependencies->queryBusPlugins() as $queryBusPlugin) {
                $this->queryBus->addPlugin($queryBusPlugin);
            }

            $this->initializeModules();

            $this->initialized = true;
        }

        return $this;

    }

    /**
     * @return EventStore
     */
    public function getEventStore(): EventStore
    {
        return $this->initialize()->eventStore;
    }

    /**
     * @return EventBus
     */
    public function getEventBus(): EventBus
    {
        return $this->initialize()->eventBus;
    }

    /**
     * @return CommandBus
     */
    public function getCommandBus(): CommandBus
    {
        return $this->initialize()->commandBus;
    }

    /**
     * @return QueryBus
     */
    public function getQueryBus(): QueryBus
    {
        return $this->initialize()->queryBus;
    }

    /**
     * @return EventRouter
     */
    public function getEventRouter(): EventRouter
    {
        return $this->initialize()->eventRouter;
    }

    /**
     * @return CommandRouter
     */
    public function getCommandRouter(): CommandRouter
    {
        return $this->initialize()->commandRouter;
    }

    /**
     * @return QueryRouter
     */
    public function getQueryRouter(): QueryRouter
    {
        return $this->initialize()->queryRouter;
    }



    protected function initializeModules()
    {
        foreach (static::modules() as $moduleClass) {
            /** @var Module $module */
            $module = new $moduleClass();
            $module->routeCommands($this->commandRouter);
            $module->routeQueries($this->queryRouter);
            $module->routeEvents($this->eventRouter);
        }

    }


}