<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 02.07.18
 *
 */

namespace Sourcekin\Content\Model\Handler\Query;

use React\Promise\Deferred;
use Sourcekin\Components\Common\HashMap;
use Sourcekin\Components\Rendering\Renderer;
use Sourcekin\Content\Model\Query\GetDocumentById;
use Sourcekin\Content\Projection\DocumentFinder;

class GetDocumentByIdHandler
{
    /**
     * @var DocumentFinder
     */
    protected $finder;

    /**
     * @var Renderer
     */
    protected $renderer;

    /**
     * GetDocumentByIdHandler constructor.
     *
     * @param DocumentFinder $finder
     * @param Renderer       $renderer
     */
    public function __construct(DocumentFinder $finder, Renderer $renderer) {
        $this->finder = $finder;
        $this->renderer = $renderer;
    }

    /**
     * @param GetDocumentById $query
     * @param Deferred|null   $deferred
     *
     * @return string
     */
    public function __invoke(GetDocumentById $query, Deferred $deferred = null)
    {
        $stream   = $this->finder->findStreamById($query->documentId());
        $document = $this->renderer->render($stream, HashMap::blank());;
        if (!$deferred) {
            return $document;
        }

        $deferred->resolve($document);
    }

}