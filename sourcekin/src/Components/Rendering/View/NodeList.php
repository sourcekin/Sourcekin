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
    /**
     * @return $this
     */
    public function sortByPosition()
    {
        $this->sort(function(ViewNode $node, ViewNode $other){ return $node->position() <=> $other->position(); });
        return $this;
    }

    public function join($glue = '')
    {
        return implode($glue, $this->toArray());
    }
}