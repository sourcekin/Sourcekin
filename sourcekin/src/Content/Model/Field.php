<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 21.06.18
 *
 */

namespace Sourcekin\Content\Model;

class Field
{

    protected $name;
    protected $value;
    protected $type;
    protected $position;

    /**
     * Field constructor.
     *
     * @param $name
     * @param $value
     * @param $type
     */
    public function __construct($name, $value, $type, $position)
    {
        $this->name  = $name;
        $this->value = $value;
        $this->type  = $type;
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    public static function from($name, $value, $type, $position)
    {
        return new static($name, $value, $type, $position);
    }

}