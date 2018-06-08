<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 07.06.18
 *
 */

namespace Sourcekin\Domain\Message;

interface DomainBusInterface
{
    /**
     * @param $message
     *
     * @return mixed
     */
    public function dispatch($message);
}