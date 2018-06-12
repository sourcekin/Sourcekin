<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 11.06.18
 *
 */

namespace SourcekinBundle\Factory;

use Doctrine\ORM\Mapping\ClassMetadataFactory;
use ReflectionClass;
use Sourcekin\Factory\ReflectionFactory;

class DoctrineMetaDateFactory extends ReflectionFactory
{

    /**
     * @var ClassMetadataFactory
     */
    protected $metadataFactory;


    /**
     * DoctrineMetaDateFactory constructor.
     *
     * @param ClassMetadataFactory $metadataFactory
     */
    public function __construct(ClassMetadataFactory $metadataFactory) {
        $this->metadataFactory = $metadataFactory;
    }


    /**
     * @param $class
     *
     * @return bool
     */
    public function isSupported($class)
    {
        try {
            $metaData = $this->metadataFactory->getMetadataFor($class);
            return true;

        } catch(\Exception $exception){
            return false;
        }

    }

    /**
     * @param $class
     *
     * @return ReflectionClass
     * @throws \Doctrine\Common\Persistence\Mapping\MappingException
     * @throws \ReflectionException
     */
    protected function getReflectionClass($class)
    {
        return $this->metadataFactory->getMetadataFor($class)->getReflectionClass();
    }


}