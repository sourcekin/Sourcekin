<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 26.06.18
 *
 */

namespace Sourcekin\Content\Model\Command;

use Sourcekin\Content\Model\DocumentRepository;

class AddFieldHandler
{
    /**
     * @var DocumentRepository
     */
    private $repository;

    /**
     * AddFieldHandler constructor.
     *
     * @param DocumentRepository $repository
     */
    public function __construct(DocumentRepository $repository) { $this->repository = $repository; }

    public function __invoke(AddField $command)
    {
        $document = $this->repository->get($command->documentId());
        $document->addField($command->contentId(), $command->name(), $command->value(), $command->type());
        $this->repository->save($document);
    }


}