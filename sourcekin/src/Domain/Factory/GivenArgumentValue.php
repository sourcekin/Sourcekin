<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 11.06.18
 *
 */

namespace Sourcekin\Domain\Factory;

class GivenArgumentValue extends ArgumentValue
{
    public function __construct($value) {
        parent::__construct($value, true);
    }


}