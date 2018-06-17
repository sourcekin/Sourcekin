<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 17.06.18.
 */

namespace Sourcekin\User\Model\Command;


use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;

class ChangeEmail extends Command {
    use PayloadTrait;

    public function id() {
        return $this->payload()['id'];
    }

    public function email() {
        return $this->payload()['email'];
    }
}