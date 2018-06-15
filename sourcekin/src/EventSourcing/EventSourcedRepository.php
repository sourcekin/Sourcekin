<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 15.06.18
 *
 */

namespace Sourcekin\EventSourcing;

use Sourcekin\EventHandling\EventBus;
use Sourcekin\EventStore\EventStoreInterface;
use Sourcekin\Exception\AggregateNotFound;
use Sourcekin\Exception\StreamNotFound;
use Sourcekin\Factory\AggregateFactory;

class EventSourcedRepository
{

    /**
     * @var EventStoreInterface
     */
    protected $eventStore;

    /**
     * @var EventBus
     */
    protected $eventBus;

    /**
     * @var string
     */
    protected $className;

    /**
     * @var AggregateFactory
     */
    protected $factory;

    /**
     * EventSourcedRepository constructor.
     *
     * @param EventStoreInterface $eventStore
     * @param EventBus            $eventBus
     * @param string              $className
     * @param AggregateFactory    $factory
     */
    public function __construct(
        EventStoreInterface $eventStore,
        EventBus $eventBus,
        string $className,
        AggregateFactory $factory
    ) {
        $this->eventStore = $eventStore;
        $this->eventBus   = $eventBus;
        $this->className  = $className;
        $this->factory    = $factory;
    }


    public function load($id)
    {
        try {
            $stream = $this->eventStore->load($id);
            return $this->factory->make($this->className, $stream);

        } catch(StreamNotFound $notFound){
            throw new AggregateNotFound(sprintf('Aggregate %s#%s not found.', $this->className, $id), 0, $notFound);
        }
    }

}