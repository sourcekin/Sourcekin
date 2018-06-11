<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 07.06.18
 *
 */

namespace SourcekinBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension as SymfonyExtension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Messenger\MessageBusInterface;

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

        $loader->load('domain-factory.php');
        $loader->load('persistence.php');

        if( $config['bus'] === 'messenger') {
            $loader->load('messenger/services.php');
            $loader->load('messenger/messages.php');
            $loader->load('messenger/console.php');
            $loader->load('messenger/command-handlers.php');
            $loader->load('messenger/event-handlers.php');
        }


        if( $config['bus'] === 'simplebus') {
            $loader->load('simplebus/services.php');
            $loader->load('simplebus/command-handlers.php');
            $loader->load('simplebus/console.php');
        }

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

        $container->prependExtensionConfig(
            'framework',
            [
                'messenger' => [
                    'default_bus' => 'messenger.bus.command',
                    'buses'       => [
                        'messenger.bus.command' => NULL,
                        'messenger.bus.event'   => NULL,
                    ],
                ],
            ]
        );
    }
}