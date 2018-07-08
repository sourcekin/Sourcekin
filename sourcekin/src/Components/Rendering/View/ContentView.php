<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 07.07.18.
 */

namespace Sourcekin\Components\Rendering\View;


use Sourcekin\Components\Common\HashMap;
use Sourcekin\Components\Rendering\Model\Content;
use Sourcekin\Components\Rendering\Model\ContentId;
use Sourcekin\Components\Rendering\Model\ContentType;

class ContentView {

    /**
     * @var HashMap
     */
    protected $vars;

    /**
     * @var HashMap
     */
    protected $attributes;
    /**
     * @var ContentId
     */
    protected $id;
    /**
     * @var ContentType
     */
    protected $type;

    /**
     * @var ContentId
     */
    protected $parent;

    /**
     * ContentView constructor.
     *
     * @param ContentId      $id
     * @param ContentType    $type
     * @param ContentId|null $parent
     * @param array          $vars
     * @param array          $attributes
     */
    protected function __construct(
        ContentId $id,
        ContentType $type = NULL,
        ContentId $parent = NULL,
        $vars = [],
        $attributes = []
    ) {
        $this->id         = $id;
        $this->type       = $type ?? ContentType::fromDefault();
        $this->vars       = new HashMap($vars);
        $this->attributes = new HashMap($attributes);
        $this->parent     = $parent;
    }

    public function id(): ContentId {
        return $this->id;
    }

    public function type(): ContentType {
        return $this->type;
    }

    public function attributes(): HashMap {
        return $this->attributes;
    }

    public function vars(): HashMap {
        return $this->vars;
    }

    public function parent() : ContentId {
        return $this->parent;
    }

    public function hasParent()
    {
        return ! $this->parent->isEmpty();
    }

    /**
     * @return int
     */
    public function position()
    {
        return (int)$this->attributes()->get('position', 0);
    }

    public static function fromData(ContentId $id, ContentType $type = NULL, ContentId $parent = NULL) {
        return new static($id, $type, $parent, [], []);
    }

    public static function fromContent(Content $content) {
        return new static(
            ContentId::fromString($content->id()),
            ContentType::fromString($content->type()),
            ContentId::fromString($content->parent()),
            $content->fields(),
            $content->attributes()
        );
    }

    public static function fromArray(array $data) {
        if (!isset($data['type']) || !\is_string($data['type'])) {
            throw new \InvalidArgumentException("Key 'type' is missing in data array or is not a string");
        }
        $type = ContentType::fromString($data['type']);

        if (!isset($data['id']) || !\is_string($data['id'])) {
            throw new \InvalidArgumentException("Key 'id' is missing in data array or is not a string");
        }
        $id = ContentId::fromString($data['id']);

        $vars       = isset($data['vars']) ? $data['vars'] : [];
        $attributes = isset($data['attributes']) ? $data['attributes'] : [];
        $parent     = isset($data['parent']) ? ContentId::fromString($data['parent']) : NULL;


        return new static($id, $type, $parent, $vars, $attributes);
    }

    public function withVars(array $vars): ContentView {
        return new static($this->id, $this->type, $this->parent, $vars, $this->attributes);
    }

    public function withAttributes(array $attribute): ContentView {
        return new static($this->id, $this->type, $this->parent, $this->vars, $attribute);
    }

    public function withType($type) {
        return new static($this->id, ContentType::fromString($type), $this->parent, $this->vars, $this->attributes);
    }

    public function withParent(ContentId $contentId) {
        return new static($this->id, $this->type, $contentId, $this->vars, $this->attributes);
    }

    public function withoutParent() {
        return new static($this->id, $this->type, NULL, $this->vars, $this->attributes);
    }

    public function toArray() {
        return [
            'id'         => $this->id->toString(),
            'type'       => $this->type->toString(),
            'vars'       => $this->vars->toArray(),
            'attributes' => $this->attributes->toArray(),
            'parent'     => $this->parent ? $this->parent->toString() : NULL,
        ];
    }

}