<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 21.06.18.
 */

namespace Sourcekin\Content\Model\Command;


use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

class AddContent extends Command implements PayloadConstructable {
    use PayloadTrait;

    public function documentId() {
        return $this->payload['document_id'];
    }

    public function identifier() {
        return $this->payload['identifier'];
    }

    public function index() {
        return $this->payload['index'];
    }

    public function type() {
        return $this->payload['type'];
    }

    public function parent() {
        return $this->payload['parent'];
    }
}