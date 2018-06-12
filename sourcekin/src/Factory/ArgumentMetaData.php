<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 11.06.18
 *
 */

namespace Sourcekin\Factory;

class ArgumentMetaData
{
    protected $name;

    protected $key;

    protected $required;

    protected $default;

    protected $type;

    /**
     * ArgumentMetaData constructor.
     *
     * @param $name
     * @param $required
     * @param $default
     * @param $type
     */
    public function __construct($name, $required, $default, $type)
    {
        $this->name     = $name;
        $this->key      = strtolower(
            preg_replace(['/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'], ['\\1_\\2', '\\1_\\2'], $name)
        );
        $this->required = $required;
        $this->default  = $default;
        $this->type     = $type;
    }

    public function name()
    {
        return $this->name;
    }

    public function key()
    {
        return $this->key;
    }

    public function required()
    {
        return $this->required;
    }

    public function default()
    {
        return $this->default;
    }

    public function type()
    {
        return $this->type;
    }


}