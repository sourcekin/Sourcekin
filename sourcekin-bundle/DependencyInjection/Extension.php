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
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension as SymfonyExtension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class Extension extends SymfonyExtension implements PrependExtensionInterface {

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
        $loader = new PhpFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));
        $config = $this->processConfiguration($this->getConfiguration($configs, $container), $configs);

        $loader->load('services.php');
        $loader->load('console.php');
        $loader->load('modules.php');
        $loader->load('user.php');

    }

    public function getConfiguration(array $config, ContainerBuilder $container) {
        return new Configuration();
    }


    /**
     * Allow an extension to prepend the extension configurations.
     *
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container) {
        $configs = $container->getExtensionConfig($this->getAlias());
        $this->prependServiceBusConfig($container);

        $repositories = [];
        $projections  = [];
        $modules = $container->getParameter('sourcekin.modules');
        foreach ($modules as $module) {
            foreach($module::repositories() as $name => $config) {
                $config['aggregate_translator'] = AggregateTranslator::class;
                $config['snapshot_store']       = PdoSnapshotStore::class;
                $repositories[$name]            = $config;
            }

            foreach ($modules::projections() as $name => $projection) {
                $projections[$name] = $projection;
            }
        }

        $config = [
            'stores' => [
                'sourcekin_store' => [
                    'event_store' => EventStore::class,
                    'repositories' => $repositories
                ]
            ],
            'projection_managers' => [
                'sourcekin_projection_manager' => [
                    'event_store' => EventStore::class,
                    'connection'  => 'doctrine.pdo.connection',
                    'projections' => $projections
                ]
            ]
        ];

        $container->prependExtensionConfig('prooph_event_store', $config);

    }

    protected function hasBundle($container, $class) {
        return in_array($class, $container->getParameter('kernel.bundles'), TRUE);
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function prependServiceBusConfig(ContainerBuilder $container): void
    {
        $config = [
            'command_buses' => ['sourcekin_command_bus' => null],
            'event_buses'   => ['sourcekin_event_bus' => null],
        ];

        $container->prependExtensionConfig('prooph_service_bus', $config);
    }
}