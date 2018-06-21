<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 21.06.18
 *
 */

namespace Sourcekin\Content\Model;

interface DocumentRepository
{
    public function save(Document $document): void;

    /**
     * @param string $id
     *
     * @return null|Document
     */
    public function get(string $id): ?Document;
}