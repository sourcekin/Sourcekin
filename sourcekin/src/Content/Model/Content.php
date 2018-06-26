<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 21.06.18
 *
 */

namespace Sourcekin\Content\Model;

class Content
{
    protected $elements = [];
    protected $fields   = [];
    protected $identifier;
    protected $type;
    protected $index;


    public static function from($identifier, $type, $index) {
        return new self($identifier, $type, $index);
    }

    private function __construct($identifier, $type, $index){

        $this->identifier = $identifier;
        $this->type       = $type;
        $this->index      = $index;
    }

    /**
     * @return mixed
     */
    public function getIndex() {
        return $this->index;
    }


    /**
     * @return mixed
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * @return mixed
     */
    public function getIdentifier() {
        return $this->identifier;
    }

    /**
     * @return mixed
     */
    public function getType() {
        return $this->type;
    }

    public function addChild(Content $content) {
        $this->elements[$content->getIdentifier()] = $content;
    }

    public function containsField($name)
    {
        return array_key_exists($name, $this->fields);
    }

    public function addField($name, $value, $type)
    {
        $field = Field::from($name, $value, $type, count($this->fields));
        $this->fields[$name] = $field;
    }

}