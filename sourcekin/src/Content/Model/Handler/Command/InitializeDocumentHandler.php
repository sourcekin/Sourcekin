<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 21.06.18
 *
 */

namespace Sourcekin\Content\Model\Handler\Command;

use Sourcekin\Content\Model\Command\InitializeDocument;
use Sourcekin\Content\Model\Document;
use Sourcekin\Content\Model\DocumentRepository;

class InitializeDocumentHandler
{
    /**
     * @var DocumentRepository
     */
    private $repository;

    /**
     * InitializeDocumentHandler constructor.
     *
     * @param DocumentRepository $repository
     */
    public function __construct(DocumentRepository $repository) { $this->repository = $repository; }


    public function __invoke(InitializeDocument $command)
    {
        $document = Document::initialize($command->name(), $command->title(), $command->content());
        $this->repository->save($document);
    }

}
