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

/**
 * Class ViewNode
 */
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
     * @var ViewNode
     */
    protected $parent;

    /**
     * @var int
     */
    protected $depth = 1;

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

    /**
     * @return \Sourcekin\Components\Rendering\Model\ContentId
     */
    public function id()
    {
        return $this->view->id();
    }

    public function depth()
    {
        return $this->parentNode() ? 1 : $this->parentNode()->depth() + 1 ;
    }
    /**
     * @return \Sourcekin\Components\Rendering\Model\ContentId
     */
    public function parent()
    {
        return $this->view->parent();
    }

    public function parentNode(){
        return $this->parent;
    }

    public function setParentNode(ViewNode $node = null)
    {
        $this->parent = $node;
        // $this->depth = $node ? $node->depth() + 1;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRoot()
    {
        return !$this->view->hasParent();
    }

    /**
     * @return ContentView
     */
    public function view() {
        return $this->view;
    }

    /**
     * @return int
     */
    public function position()
    {
        return $this->view->position();
    }

    /**
     * @param ContentView $view
     *
     * @return ViewNode
     */
    public static function fromView(ContentView $view)
    {
        return new static($view);
    }

    /**
     * @param ViewNode $view
     *
     * @return $this
     */
    public function addChild(ViewNode $view)
    {
        if (!$view->parent()->equals($this->id())) {
            throw AssociationMismatch::forAssociation($this, $view);
        }

        $view->setParentNode($this);
        $this->children->set((string)$view->id(), $view);

        return $this;
    }

    /**
     * @return HashMap|NodeList
     */
    public function children()
    {
        return $this->children;
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->children()->count();
    }

    /**
     * @return \Sourcekin\Components\Rendering\Model\ContentType
     */
    public function type() {
        return $this->view->type();
    }

    /**
     * @return array
     */
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

    public function selfToArray()
    {
        return $this->view->toArray();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @return callable|\Closure|mixed|string
     */
    public function content()
    {
        if (is_callable($this->content)) {
            $this->content = call_user_func($this->content);
        }

        return $this->content;

    }

    /**
     * @return string
     */
    public function toString() : string
    {
        return $this->content();
    }


}