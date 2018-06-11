<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 11.06.18
 *
 */

namespace SourcekinBundle\Factory;

use Doctrine\ORM\Mapping\ClassMetadataFactory;
use Sourcekin\Domain\Factory\DomainObjectFactory;
use Sourcekin\Domain\Factory\FactoryInterface;

class DoctrineMetaDateFactory implements FactoryInterface
{

    /**
     * @var ClassMetadataFactory
     */
    protected $metadataFactory;

    /**
     * @param $class
     *
     * @return bool
     */
    public function isSupported($class)
    {
        return $this->metadataFactory->hasMetadataFor($class);
    }

    /**
     * @param                     $class
     * @param DomainObjectFactory $factory
     * @param array               $context
     *
     * @return object
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \ReflectionException
     */
    public function make($class, DomainObjectFactory $factory, array $context = [])
    {
        $metaData   = $this->metadataFactory->getMetadataFor($class);
        $reflection = $metaData->getReflectionClass();
        $args       = [];
        foreach($reflection->getConstructor()->getParameters() as $parameter) {
            $args[$parameter->getName()] = $context[$parameter->getName()] ?? null;


            if( $subclass = $parameter->getClass()->getName()) {
                $context[$parameter->getName()] = $factory->make($subclass);
            }
        }

        return $metaData->getReflectionClass()->newInstance($context);
    }
}