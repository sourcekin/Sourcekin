<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 21.06.18
 *
 */

namespace Sourcekin\Content\Model\Event;

use Prooph\EventSourcing\AggregateChanged;

class DocumentWasInitialized extends AggregateChanged
{

    public function title(){
        return $this->payload['title'];
    }

    public function name()
    {
        return $this->payload['name'];
    }

    public function content()
    {
        return $this->payload['content'];
    }
}