<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 11.06.18
 *
 */

namespace Sourcekin\Domain\Factory;

class ArgumentValue
{
    protected $value = null;
    protected $given = true;

    /**
     * ArgumentValue constructor.
     *
     * @param null $value
     * @param bool $given
     */
    public function __construct($value, bool $given)
    {
        $this->value = $value;
        $this->given = $given;
    }

    public function value() {
        return $this->value;
    }

    public function given()
    {
        return $this->given;
    }


}