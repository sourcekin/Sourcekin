<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 17.06.18
 *
 */

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Sourcekin\Components\PasswordEncoder;
use SourcekinBundle\ReadModel\User\SecurityUser;
use SourcekinBundle\Security\Encoder;
use SourcekinBundle\Security\UserProvider;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

return function(ContainerConfigurator $container) {

    $container->services()->defaults()->autowire()->autoconfigure()->private()

        ->set('sourcekin.password_encoder', UserPasswordEncoderInterface::class)
        ->factory([new Reference('security.encoder_factory'), 'getEncoder'])
        ->arg('$user', SecurityUser::class)

        ->set(Encoder::class)
        ->arg('$encoder', new Reference('sourcekin.password_encoder'))
        ->alias(PasswordEncoder::class, Encoder::class)

        ->set('sourcekin.security_user.repository', EntityRepository::class)
        ->factory([new Reference(ObjectManager::class), 'getRepository'])
        ->arg('$entityName', SecurityUser::class)

        ->set(UserProvider::class)
        ->arg('$repository', new Reference('sourcekin.security_user.repository'))
        ;

};