<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 19.06.18
 *
 */

namespace SourcekinBundle\EventListener;

use Prooph\Bundle\EventStore\Projection\Projection;
use Prooph\Bundle\EventStore\Projection\ReadModelProjection;
use Prooph\EventStore\Projection\ProjectionManager;
use Psr\Container\ContainerInterface;
use RuntimeException;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ProjectionsSubscriber implements EventSubscriberInterface
{
    /**
     * @var ProjectionManager
     */
    protected $projectionManager;

    /**
     * @var Projection
     */
    protected $projection;

    /**
     * @var ContainerInterface
     */
    private $projectionManagerForProjectionsLocator;

    /**
     * @var ContainerInterface
     */
    protected $projectionsLocator;

    /**
     * @var ContainerInterface
     */
    protected $projectionReadModelLocator;

    public function __construct(
        ContainerInterface $projectionManagerForProjectionsLocator,
        ContainerInterface $projectionsLocator,
        ContainerInterface $projectionReadModelLocator
    )
    {
        $this->projectionManagerForProjectionsLocator = $projectionManagerForProjectionsLocator;
        $this->projectionsLocator                     = $projectionsLocator;
        $this->projectionReadModelLocator             = $projectionReadModelLocator;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::TERMINATE  => 'onKernelTerminate',
            ConsoleEvents::TERMINATE => 'onConsoleTerminate',
        ];
    }

    protected function runProjection($name)
    {
        if (! $this->projectionManagerForProjectionsLocator->has($name)) {
            throw new RuntimeException(sprintf('ProjectionManager for "%s" not found', $name));
        }
        $modelProjection  = null;
        $projectionManager = $this->projectionManagerForProjectionsLocator->get($name);

        if (! $this->projectionsLocator->has($name)) {
            throw new RuntimeException(sprintf('Projection "%s" not found', $name));
        }
        $projection = $this->projectionsLocator->get($name);

        if ($projection instanceof ReadModelProjection) {
            if (! $this->projectionReadModelLocator->has($name)) {
                throw new RuntimeException(sprintf('ReadModel for "%s" not found', $name));
            }
            $readModel = $this->projectionReadModelLocator->get($name);

            $modelProjection = $projectionManager->createReadModelProjection($name, $readModel);
        }

        if ($projection instanceof Projection) {
            $modelProjection = $projectionManager->createProjection($name);
        }

        $projector = $projection->project($modelProjection);
        $projector->run(false);
    }

    public function onConsoleTerminate(ConsoleTerminateEvent $event)
    {

    }

    public function onKernelTerminate(PostResponseEvent $event)
    {
    }


}