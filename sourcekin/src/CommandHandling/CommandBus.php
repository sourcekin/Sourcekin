<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 15.06.18.
 */

namespace Sourcekin\CommandHandling;


interface CommandBus {
    public function execute($command);
}