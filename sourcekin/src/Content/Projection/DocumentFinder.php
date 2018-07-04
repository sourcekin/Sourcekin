<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 29.06.18.
 */

namespace Sourcekin\Content\Projection;


use Elasticsearch\Client;

class DocumentFinder {
    /**
     * @var Client
     */
    protected $client;

    /**
     * DocumentFinder constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client) {
        $this->client = $client;
    }

    public function findById($id) {
        $source =  $this->client->getSource(['index' => DocumentModelElasticSearch::INDEX, 'type' => 'document', 'id' => $id]);

        return $source;
    }
}