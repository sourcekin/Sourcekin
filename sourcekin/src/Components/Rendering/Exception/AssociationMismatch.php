<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 08.07.18
 *
 */

namespace Sourcekin\Components\Rendering\Exception;

use Sourcekin\Components\Rendering\Model\ContentId;
use Sourcekin\Components\Rendering\View\ViewNode;

class AssociationMismatch extends \InvalidArgumentException
{

    public static function forAssociation(ViewNode $parent, ViewNode $child)
    {
        return new static(
            sprintf(
                'Parent for node "%s" is expected to be "%s" but was "%s".',
                $child->id()->toString(),
                $child->parent()->toString(),
                $parent->id()->toString()
            )
        );
    }
}