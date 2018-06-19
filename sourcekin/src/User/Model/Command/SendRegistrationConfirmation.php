<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 19.06.18.
 */

namespace Sourcekin\User\Model\Command;


use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

class SendRegistrationConfirmation extends Command implements PayloadConstructable {

    use PayloadTrait;

    public static function withUserId($userId) {
        return new static(['id' => $userId]);
    }

    public function id() {
        return $this->payload()['id'];
    }
}