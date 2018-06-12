<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 11.06.18
 *
 */

namespace Sourcekin\Factory;

class DefaultArgumentValue extends ArgumentValue
{

    /**
     * DefaultArgumentValue constructor.
     */
    public function __construct($value) {
        parent::__construct($value, false);
    }
}