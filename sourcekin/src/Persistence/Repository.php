<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 15.06.18
 *
 */

namespace Sourcekin\Persistence;

interface Repository
{
    /**
     * @param mixed $id
     *
     * @return Identifiable|null
     */
    public function find($id);

    /**
     * @param array $fields
     *
     * @return Identifiable[]
     */
    public function findBy(array $fields): array;

    /**
     * @return Identifiable[]
     */
    public function findAll(): array;
}