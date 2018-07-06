<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 06.07.18.
 */

namespace Sourcekin\Components\Rendering;


use Sourcekin\Components\Rendering\Model\Content;

class ContentStream {

    protected $contents;

    /**
     * ContentStream constructor.
     *
     * @param $contents
     */
    public function __construct($contents = []) {
        $this->contents = $contents;
    }

    public function append(Content $content) {
        $this->contents[] = $content;
    }


    /**
     * @param mixed ...$contents
     *
     * @return ContentStream
     */
    public static function withContents( ... $contents) {
        return new static($contents);
    }

    /**
     * @return Content[]|iterable
     */
    public function contents() : iterable {
        yield from $this->contents;
    }

}