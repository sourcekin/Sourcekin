<?php

// this file is auto-generated by prolic/fpp
// don't edit this file manually

declare(strict_types=1);

namespace Sourcekin\Components\Rendering\Model;

final class Content {
    /**
     * @var ContentType
     */
    protected $type;
    /**
     * @var Field[]
     */
    protected $fields;
    /**
     * @var Attribute[]
     */
    protected $attributes;

    /**
     * Content constructor.
     *
     * @param ContentType $type
     * @param Field[]     $fields
     * @param Attribute[] $attributes
     */
    public function __construct(ContentType $type, array $fields = [], array $attributes = []) {
        $this->type       = $type;
        $this->fields     = $fields;
        $this->attributes = $attributes;
    }


    public function type() {
        return $this->type;
    }

    public static function withType($type) {
        return new static(ContentType::fromString($type));
    }
}
