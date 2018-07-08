<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 08.07.18
 *
 */

namespace Sourcekin\Components\Rendering\View;

use Sourcekin\Components\Common\HashMap;
use Sourcekin\Components\Rendering\Exception\AssociationMismatch;

class ViewNode
{
    /**
     * @var ContentView
     */
    protected $view;

    /**
     * @var HashMap
     */
    protected $children;

    /**
     * @var string|callable
     */
    protected $content;

    /**
     * ViewNode constructor.
     *
     * @param ContentView $view
     */
    public function __construct(ContentView $view)
    {
        $this->view     = $view;
        $this->children = new NodeList();
        $this->content  = function() {
            return json_encode($this->toArray());
        };
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string|callable $content
     *
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function id()
    {
        return $this->view->id();
    }

    public function parent()
    {
        return $this->view->parent();
    }

    public function isRoot()
    {
        return !$this->view->hasParent();
    }

    /**
     * @return int
     */
    public function position()
    {
        return $this->view->position();
    }

    public static function fromView(ContentView $view)
    {
        return new static($view);
    }

    public function addChild(ViewNode $view)
    {
        if (!$view->parent()->equals($this->id())) {
            throw AssociationMismatch::forAssociation($this, $view);
        }

        $this->children->set((string)$view->id(), $view);

        return $this;
    }

    public function children()
    {
        return $this->children;
    }

    public function count()
    {
        return $this->children()->count();
    }

    public function toArray()
    {
        $self             = $this->view->toArray();
        $self['children'] = $this->children->sortByPosition()->map(
            function (ViewNode $node) {
                return $node->toArray();
            }
        )->values()
        ;

        return $self;
    }

    public function __toString()
    {
        return $this->toString();
    }

    public function content()
    {
        if (is_callable($this->content)) {
            $this->content = call_user_func($this->content);
        }

        return $this->content;

    }

    public function toString() : string
    {
        return $this->content();
    }


}