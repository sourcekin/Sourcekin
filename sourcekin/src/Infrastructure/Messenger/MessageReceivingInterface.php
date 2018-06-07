<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 07.06.18
 *
 */

namespace Sourcekin\Infrastructure\Messenger;

interface MessageReceivingInterface
{
    public function onMessageReceived($message);
}