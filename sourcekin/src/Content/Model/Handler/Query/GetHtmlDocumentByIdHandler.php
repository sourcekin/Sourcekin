<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 08.07.18.
 */

namespace Sourcekin\Content\Model\Handler\Query;


use Sourcekin\Components\Rendering\Renderer;
use Sourcekin\Content\Model\Query\GetHtmlDocumentById;
use Sourcekin\Content\Projection\DocumentFinder;

class GetHtmlDocumentByIdHandler {
    /**
     * @var DocumentFinder
     */
    protected $finder;
    /**
     * @var Renderer
     */
    protected $renderer;

    protected $watch;

    /**
     * GetHtmlDocumentByIdHandler constructor.
     *
     * @param DocumentFinder $finder
     * @param Renderer       $renderer
     */
    public function __construct(DocumentFinder $finder, Renderer $renderer) {
        $this->finder   = $finder;
        $this->renderer = $renderer;
    }

    /**
     * @return mixed
     */
    public function getWatch()
    {
        return $this->watch;
    }

    /**
     * @param mixed $watch
     *
     * @return $this
     */
    public function setWatch($watch)
    {
        $this->watch = $watch;

        return $this;
    }



    public function __invoke(GetHtmlDocumentById $query) {

        $document = $this->finder->findById($query->getDocumentId());

    }

}