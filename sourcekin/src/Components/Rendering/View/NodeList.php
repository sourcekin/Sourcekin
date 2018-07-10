<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 08.07.18
 *
 */

namespace Sourcekin\Components\Rendering\View;

use Sourcekin\Components\Common\HashMap;

class NodeList extends HashMap
{
    public function set($name, $value) {
        if( ! $value instanceof ViewNode ) throw new \InvalidArgumentException();
        return parent::set($name, $value);
    }


    /**
     * @return $this
     */
    public function sortByPosition()
    {
        return $this->sort(function(ViewNode $node, ViewNode $other){ return $node->position() <=> $other->position(); });
    }

    /**
     * @return NodeList
     */
    public function sortByDepth()
    {
        return $this->sort(function(ViewNode $node, ViewNode $other){ return $other->depth() <=> $node->depth(); });
    }

    public function join($glue = '')
    {
        return implode($glue, array_map(function($n){ return $n->toString(); }, $this->elements));
    }

    public function buildTree() {
        return $this->map(function(ViewNode $node){
            if( $this->has((string)$node->parent())) {
                $this->get((string)$node->parent())->addChild($node);
            }
            return $node;
        });
    }

    public function rootNodes()
    {
        return $this->filter(function(ViewNode $node){ return $node->isRoot();});
    }

    public function toString()
    {
        return $this->join();
    }

    public function __toString()
    {
        return $this->toString();
    }

    public function toArray() {
        return array_map(function($node){ return $node->toArray(); }, $this->elements);
    }
}