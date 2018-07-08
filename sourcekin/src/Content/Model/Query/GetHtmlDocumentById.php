<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 08.07.18.
 */

namespace Sourcekin\Content\Model\Query;


class GetHtmlDocumentById {
    private $documentId;

    /**
     * GetHtmlDocumentById constructor.
     *
     * @param $documentId
     */
    public function __construct($documentId) { $this->documentId = $documentId; }

    /**
     * @return mixed
     */
    public function getDocumentId() {
        return $this->documentId;
    }


}