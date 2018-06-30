<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 07.06.18
 *
 */

namespace SourcekinBundle\DependencyInjection;

use Sourcekin\Application;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension as SymfonyExtension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class SourcekinExtension extends SymfonyExtension {

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

        $loader = new PhpFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config/container'));
        $this->defineParameters($container);

        $loader->load('services.php');
        $loader->load('service-buses.php');
        $loader->load('console-commands.php');
        $loader->load('projectors.php');
        $loader->load('service-bus-plugins.php');
        $loader->load('controllers.php');

        $loader->load('user-module.php');
        $loader->load('content-module.php');
    }


    /**
     * Allow an extension to prepend the extension configurations.
     *
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container) {
    }

    protected function hasBundle(ContainerBuilder $container, $class) {
        return in_array($class, $container->getParameter('kernel.bundles'), TRUE);
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