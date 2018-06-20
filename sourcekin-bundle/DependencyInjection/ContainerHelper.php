<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 20.06.18.
 */

namespace SourcekinBundle\DependencyInjection;


use ReflectionClass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ContainerHelper {
    public static function getHandledCommand($id, ContainerBuilder $builder)
    {
        $class = $builder->findDefinition($id)->getClass()??$id;
        return (new ReflectionClass($class))->getMethod('__invoke')->getParameters()[0]->getClass()->getName();
    }
}