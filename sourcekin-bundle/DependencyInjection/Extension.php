<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 07.06.18
 *
 */

namespace SourcekinBundle\DependencyInjection;

use Sourcekin\Domain\Message\DomainBusInterface;
use Sourcekin\Infrastructure\Console\MessageReceiver;
use Sourcekin\Infrastructure\DependencyInjection\ConfigurationHelper;
use Sourcekin\Infrastructure\Messenger\DomainBus;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension as SymfonyExtension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class Extension extends SymfonyExtension
{
    const ALIAS = 'sourcekin';

    /**
     * Loads a specific configuration.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new PhpFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));
        $config = $this->processConfiguration($this->getConfiguration($configs, $container), $configs);
        $loader->load('services.php');

        if( class_exists(ConsoleEvents::class)) {
            $loader->load('console.php');
        }

        ConfigurationHelper::configureEventMessages($container, [], array_map(function($file){ return 'Sourcekin\\Domain\\Event\\' . basename($file, '.php'); }, glob(ConfigurationHelper::getPackagePath('/Domain/Event/*.php'))) );
    }

    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new Configuration();
    }


}