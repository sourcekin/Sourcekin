<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 21.06.18.
 */

namespace Sourcekin\Content\Model\Command;


use Sourcekin\Content\Model\Document;
use Sourcekin\Content\Model\DocumentRepository;

class AddContentHandler {
    /**
     * @var DocumentRepository
     */
    private $repository;

    /**
     * AddContentHandler constructor.
     *
     * @param DocumentRepository $repository
     */
    public function __construct(DocumentRepository $repository) { $this->repository = $repository; }

    public function __invoke(AddContent $command) {
        /** @var Document $document */
        $document = $this->repository->get($command->documentId());
        $document->addContent($command->identifier(), $command->type(), $command->index(), $command->parent());
        $this->repository->save($document);
    }


}