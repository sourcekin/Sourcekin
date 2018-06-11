<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 11.06.18
 *
 */

namespace Sourcekin\Domain\Persistence;

interface ObjectStore
{
    function store($object);

    function remove($object);

}