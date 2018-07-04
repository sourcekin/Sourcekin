<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 02.07.18
 *
 */

namespace Sourcekin\Content\Model\Handler\Query;

use React\Promise\Deferred;
use Sourcekin\Content\Model\Query\GetDocumentById;
use Sourcekin\Content\Projection\DocumentFinder;

class GetDocumentByIdHandler
{
    /**
     * @var DocumentFinder
     */
    protected $finder;

    /**
     * GetDocumentByIdHandler constructor.
     *
     * @param DocumentFinder $finder
     */
    public function __construct(DocumentFinder $finder) { $this->finder = $finder; }

    /**
     * @param GetDocumentById $query
     * @param Deferred|null   $deferred
     *
     * @return array
     */
    public function __invoke(GetDocumentById $query, Deferred $deferred = null)
    {
        $document = $this->finder->findById($query->documentId());
        if (!$deferred) {
            return $document;
        }

        $deferred->resolve($document);
    }

}