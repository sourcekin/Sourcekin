<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 05.06.18
 *
 */

namespace Sourcekin\Domain\Command\Handler;

use Sourcekin\Domain\Command\HelloCommand;
use Sourcekin\Domain\Message\BusInterface;

class HelloHandler
{
    /**
     * @var BusInterface
     */
    protected $bus;

    public function __invoke(HelloCommand $command)
    {

    }

}