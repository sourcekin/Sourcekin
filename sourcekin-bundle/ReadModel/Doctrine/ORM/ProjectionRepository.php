<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 17.06.18
 *
 */

namespace SourcekinBundle\ReadModel\Doctrine\ORM;

use Broadway\ReadModel\Identifiable;
use Broadway\ReadModel\Repository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

class ProjectionRepository implements Repository
{

    /**
     * @var ObjectManager
     */
    protected $em;

    /**
     * @var
     */
    protected $className;

    /**
     * ProjectionRepository constructor.
     *
     * @param ObjectManager $em
     * @param               $className
     */
    public function __construct(ObjectManager $em, $className)
    {
        $this->em        = $em;
        $this->className = $className;
    }

    protected function repository()
    {
        return $this->em->getRepository($this->className);
    }

    public function save(Identifiable $data)
    {
        $this->em->persist($data);
        $this->em->flush($data);
    }

    /**
     * @param mixed $id
     *
     * @return Identifiable|null
     */
    public function find($id)
    {
        return $this->repository()->find($id);
    }

    /**
     * @param array $fields
     *
     * @return Identifiable[]
     */
    public function findBy(array $fields): array
    {
        return $this->repository()->findBy($fields);
    }

    /**
     * @return Identifiable[]
     */
    public function findAll(): array
    {
        return $this->repository()->findAll();
    }

    /**
     * @param mixed $id
     */
    public function remove($id)
    {
        $entity = $this->reference($id);
        $this->em->remove($entity);
        $this->em->flush($entity);

    }

    /**
     * @param $id
     *
     * @return bool|\Doctrine\Common\Proxy\Proxy|null|object
     * @throws \Doctrine\ORM\ORMException
     */
    protected function reference($id)
    {
        return $this->em->getReference($this->className, $id);
}
}