<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 07.06.18
 *
 */

namespace SourcekinBundle\DependencyInjection;

use Sourcekin\User\ReadModel\LoginUser;
use SourcekinBundle\ReadModel\Doctrine\ORM\SecurityUserRepository;
use SourcekinBundle\ReadModel\User\SecurityUser;
use SourcekinBundle\Security\UserProvider;
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
        $loader->load('security.php');
        $loader->load('console.php');
        $loader->load('domain/user.php');
        $loader->load('read-model/user.php');



    }

    public function getConfiguration(array $config, ContainerBuilder $container) {
        return new Configuration();
    }

    public function configureDoctrineTargetEntities(ContainerBuilder $container, $classMapping) {
        $container->prependExtensionConfig('doctrine', [
            'orm' => [
                'mappings' => [
                    'Sourcekin' => [
                        'type'      => 'xml',
                        'dir'       => dirname(__DIR__).'/Resources/config/doctrine/orm',
                        'alias'     => 'Sourcekin',
                        'prefix'    => 'Sourcekin',
                        'is_bundle' => false,
                    ],
                    'SourcekinBundle' => [
                        'type'      => 'xml',
                        'dir'       => dirname(__DIR__).'/Resources/config/doctrine/orm',
                        'alias'     => 'SourcekinBundle',
                        'prefix'    => 'SourcekinBundle',
                        'is_bundle' => false,
                    ]
                ]
            ]
        ]);
    }

    /**
     * Allow an extension to prepend the extension configurations.
     *
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container) {
        $this->configureDoctrineTargetEntities($container, []);
        $this->configureSecurity($container);

    }

    protected function hasBundle($container, $class) {
        return in_array($class, $container->getParameter('kernel.bundles'), true);
    }

    private function configureSecurity(ContainerBuilder $container) {
        $container->prependExtensionConfig('security', [
            'encoders' => [
                SecurityUser::class => [
                    'algorithm' => 'bcrypt',
                    'cost'      => 12
                ]
            ],
            'providers' => [
                'security_user' => [
                    'id' => UserProvider::class
                ]
            ]
        ]);
    }
}