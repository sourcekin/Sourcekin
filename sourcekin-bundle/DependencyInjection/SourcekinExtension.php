<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 07.06.18
 *
 */

namespace SourcekinBundle\DependencyInjection;

use Prooph\EventSourcing\Aggregate\AggregateTranslator;
use Prooph\EventStore\EventStore;
use Prooph\SnapshotStore\Pdo\PdoSnapshotStore;
use Sourcekin\Application;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension as SymfonyExtension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class SourcekinExtension extends SymfonyExtension implements PrependExtensionInterface {

    const ALIAS = 'sourcekin';


    /**
     * Loads a specific configuration.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container) {

        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new PhpFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));
        $this->defineParameters($container);
        $loader->load('services.php');
        $loader->load('console.php');
        $loader->load('user.php');

    }


    /**
     * Allow an extension to prepend the extension configurations.
     *
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container) {
        $this->prependServiceBusConfig($container);
        $this->prependEventStoreConfig($container);

    }

    protected function hasBundle($container, $class) {
        return in_array($class, $container->getParameter('kernel.bundles'), TRUE);
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function prependServiceBusConfig(ContainerBuilder $container): void {
        $routes = $this->listEventRoutes(Application::modules());
        $config = [
            'command_buses' => [
                'sourcekin_command_bus' => NULL,
            ],
            'event_buses'   => [
                'sourcekin_event_bus' => [
                    'router' => [
                        'routes' => $routes,
                    ],
                ],
            ],
        ];

        $container->prependExtensionConfig('prooph_service_bus', $config);
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function prependEventStoreConfig(ContainerBuilder $container): void {
        $repositories = $projections = [];
        foreach (Application::modules() as $name => $module) {
            foreach ($module::repositories() as $name => $config) {
                $config['aggregate_translator'] = AggregateTranslator::class;
                $config['snapshot_store']       = PdoSnapshotStore::class;
                $repositories[$name]            = $config;
            }

            foreach ($module::projections() as $name => $projection) {
                $projections[$name] = $projection;
            }
        }

        $config = [
            'stores'              => [
                'sourcekin_store' => [
                    'event_store'  => EventStore::class,
                    'repositories' => $repositories,
                ],
            ],
            'projection_managers' => [
                'sourcekin_projection_manager' => [
                    'event_store' => EventStore::class,
                    'connection'  => 'doctrine.pdo.connection',
                    'projections' => $projections,
                ],
            ],
        ];

        $container->prependExtensionConfig('prooph_event_store', $config);
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function defineParameters(ContainerBuilder $container): void {
        $modules     = Application::modules();
        $streams     = array_filter(array_map(function ($class) { return $class::streamName(); }, $modules));
        $projections = $this->listProjections($modules);
        $eventRoutes = $this->listEventRoutes($modules);

        $container->setParameter('sourcekin.modules', $modules);
        $container->setParameter('sourcekin.stream_names', $streams);
        $container->setParameter('sourcekin.projections', $projections);
        $container->setParameter('sourcekin.event_routes', $eventRoutes);

    }

    /**
     * @param $modules
     *
     * @return array
     */
    protected function listProjections($modules): array {
        $projections = [];
        foreach ($modules as $module) {
            $projections = array_merge($projections, array_keys($module::projections()));
        }

        return $projections;
    }

    /**
     * @param $modules
     *
     * @return array
     */
    protected function listEventRoutes($modules): array {
        $eventRoutes = [];
        foreach ($modules as $module) {
            $eventRoutes = array_merge($eventRoutes, $module::eventRoutes());
        }

        return $eventRoutes;
}
}