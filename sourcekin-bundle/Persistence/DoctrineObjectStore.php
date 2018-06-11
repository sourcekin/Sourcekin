<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 11.06.18
 *
 */

namespace SourcekinBundle\Persistence;

use Doctrine\ORM\EntityManager;
use Sourcekin\Domain\Persistence\ObjectStore;

class DoctrineObjectStore implements ObjectStore
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * DoctrineObjectStore constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $object
     *
     * @throws \Doctrine\ORM\ORMException
     */
    function store($object)
    {
        $this->entityManager->persist($object);
    }

    /**
     * @param $object
     *
     * @throws \Doctrine\ORM\ORMException
     */
    function remove($object)
    {
        $this->entityManager->remove($object);
    }
}