<?php
/**
 * This file is part of the "sourcekin" Project.
 *
 * Created by avanzu on 02.07.18
 *
 */

namespace Sourcekin\Content\Model\Query;

class GetDocumentById
{
    protected $documentId;

    /**
     * GetDocumentById constructor.
     *
     * @param $documentId
     */
    public function __construct($documentId) { $this->documentId = $documentId; }

    /**
     * @return mixed
     */
    public function documentId()
    {
        return $this->documentId;
    }




}