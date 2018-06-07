<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 06.06.18
 *
 */

namespace Sourcekin\Infrastructure\DependencyInjection\Compiler;

use Sourcekin\Domain\Message\MessageBusInterface;
use Sourcekin\Infrastructure\DependencyInjection\ConfigurationHelper;
use Sourcekin\Infrastructure\Messenger\FallbackHandler;
use Sourcekin\Infrastructure\Messenger\MessageBus;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class InitializeDomainPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->has(MessageBusInterface::class)) return;
        $container->register(MessageBus::class, MessageBus::class)->setAutowired(true)->setPublic(false);
        $container->setAlias(MessageBusInterface::class, MessageBus::class);
        foreach ($container->findTaggedServiceIds('sourcekin.domain.command_handler') as $id => $tag) {
            $definition = $container->findDefinition($id);
            $command = $this->evaluateCommandClass($container, $definition, $id);

            $definition->addTag('messenger.message_handler', ['handles' => $command]);
        }

        $messageHandler = $container->register(FallbackHandler::class, FallbackHandler::class);
        $events = array_map(function($file) { return "Sourcekin\\Domain\\Event\\" . basename($file,'.php'); }, glob(ConfigurationHelper::getPackageDir().'/Event/*.php'));
        foreach ($events as $event) {
            $messageHandler->addTag('messenger.message_handler', ['handles' => $event]);
        }


    }

    /**
     * @param ContainerBuilder $container
     * @param                  $definition
     * @param                  $id
     *
     * @return string
     * @throws \ReflectionException
     */
    protected function evaluateCommandClass(ContainerBuilder $container, $definition, $id): string
    {
        return $container->getReflectionClass($definition->getClass() ?? $id)->getMethod('__invoke')->getParameters(
        )[0]->getClass()->getName()
            ;
}
}