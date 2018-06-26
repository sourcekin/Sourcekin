<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 21.06.18.
 */

namespace Sourcekin\Content\Model\Event;

use Prooph\EventSourcing\AggregateChanged;

class ContentWasAdded extends AggregateChanged
{


    public function documentId()
    {
        return $this->payload['document_id'];
    }

    public function index()
    {
        return $this->payload['index'];
    }

    public function parent()
    {
        return $this->payload['parent'];
    }

    public function type()
    {
        return $this->payload['type'];
    }

    public function identifier()
    {
        return $this->payload['identifier'];
    }

}