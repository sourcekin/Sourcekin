<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 05.06.18
 *
 */

namespace Sourcekin\Domain\Message;

interface MessageReceiverInterface
{
    public function onMessageReceived($message);
}