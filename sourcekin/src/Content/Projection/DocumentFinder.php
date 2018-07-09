<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 29.06.18.
 */

namespace Sourcekin\Content\Projection;


use Elasticsearch\Client;
use Sourcekin\Components\Common\HashMap;
use Sourcekin\Components\Rendering\ContentStream;
use Sourcekin\Components\Rendering\Model\Content;
use Sourcekin\Components\Rendering\ViewBuilder;

class DocumentFinder {
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var ViewBuilder
     */
    protected $builder;

    /**
     * DocumentFinder constructor.
     *
     * @param Client      $client
     * @param ViewBuilder $renderer
     */
    public function __construct(Client $client, ViewBuilder $renderer) {
        $this->client  = $client;
        $this->builder = $renderer;
    }

    public function findStreamById($id) {
        $source = $this->client->getSource(
            [
                'index' => DocumentModelElasticSearch::INDEX,
                'type'  => 'document',
                'id'    => $id,
            ]
        );

        $stream = ContentStream::withContents(Content::fromPayload($source));

        $matches = ($this->client->search(
            [
                'index' => DocumentModelElasticSearch::INDEX,
                'type'  => 'document',
                'body'  => [
                    'query' => [
                        'match' => ['owner' => $id],
                    ],
                ],
            ]
        ));

        foreach ($matches['hits']['hits'] as $hit) {
            $stream->append(Content::fromPayload($hit['_source']));
        }

        return $stream;
    }

    public function findById($id) {

        return $this->builder->buildNodeList($this->findStreamById($id), HashMap::blank())->rootNodes()->toArray();
    }
}