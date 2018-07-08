<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 26.06.18
 *
 */

namespace Sourcekin\Content\Model\Event;

use Prooph\EventSourcing\AggregateChanged;
use Sourcekin\Content\Model\Field;

class FieldWasAdded extends AggregateChanged
{
    /**
     * @var Field
     */
    protected $field;

    public function contentId()
    {
        return $this->payload['content_id'];
    }

    public function name()
    {
        return $this->payload['name'];
    }

    public function value()
    {
        return $this->payload['value'];
    }

    public function type()
    {
        return $this->payload['type'];
    }

    public function index() {
        return $this->payload['index'];
    }

}