<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 21.06.18
 *
 */

namespace Sourcekin\Content\Model\Command;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

class InitializeDocument extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public function id()
    {
        return $this->payload['id'];
    }

    public function title()
    {
        return $this->payload['title'];
    }

    public function content()
    {
        return $this->payload['content'];
    }

    public function name()
    {
        return $this->payload['name'];
    }
}