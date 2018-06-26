<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 26.06.18
 *
 */

namespace Sourcekin\Content\Model\Command;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

class AddField extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public function documentId()
    {
        return $this->payload['document_id'];
    }

    public function contentId() {
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
}