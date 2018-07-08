<?php
/**
 * This file is part of the "sourcekin" Project.
 * Created by {avanzu} on 29.06.18.
 */

namespace Sourcekin\Content\Projection;


use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Prooph\EventStore\Projection\AbstractReadModel;

class DocumentModelElasticSearch extends AbstractReadModel {

    const INDEX = 'document';

    /**
     * @var Client
     */
    protected $client;

    /**
     * DocumentModelElasticSearch constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client) { $this->client = $client; }


    public function init(): void {
        if (!$this->createIndex()) {
            throw new \RuntimeException('could not init');
        }
    }

    public function isInitialized(): bool {
        return $this->client->indices()->exists(['index' => static::INDEX]);
    }

    public function reset(): void {
        if (!$this->deleteIndex()) {
            throw new \RuntimeException('could not delete index');
        }
    }

    public function delete(): void {
        $this->deleteIndex();
        $this->createIndex();
    }

    public function insert($data) {


        $params = [
            'index'   => static::INDEX,
            'id'      => $data['id'],
            'type'    => 'document',
            'body'    => $data,
            'refresh' => TRUE,
        ];

        $this->client->index($params);
    }

    public function addContent($data) {

        $this->client->index(
            [
                'index'   => static::INDEX,
                'type'    => 'document',
                'id'      => $data['id'],
                'body'    => $data,
                'refresh' => TRUE,
            ]
        );
    }

    public function addField($data) {

        $hit             = $this->client->getSource(
            ['index' => static::INDEX, 'type' => 'document', 'id' => $data['id']]
        );
        $hit['fields'][] = $data;

        $this->client->index(
            [
                'index'   => static::INDEX,
                'type'    => 'document',
                'id'      => $data['id'],
                'body'    => $hit,
                'refresh' => TRUE,
            ]
        );
    }

    /**
     * @return bool
     */
    protected function createIndex(): bool {
        $params = [
            'index' => static::INDEX,
            'body'  => [
                'settings' => [
                    'number_of_shards'   => 2,
                    'number_of_replicas' => 0,
                ],
            ],
        ];

        $this->client->indices()->create($params);

        $response = $this->client->cluster()->health(
            [
                'index'           => static::INDEX,
                'wait_for_status' => 'yellow',
                'timeout'         => '5s',
            ]
        )
        ;

        return isset($response['status']) && $response['status'] !== 'red';
    }

    /**
     * @return bool
     */
    protected function deleteIndex(): bool {
        $indexParams = [
            'index' => static::INDEX,
        ];

        try {
            $this->client->indices()->delete($indexParams);

        }
        catch (Missing404Exception $e) {
            return TRUE;
        }
        $response = $this->client->cluster()->health(
            [
                'wait_for_status' => 'yellow',
                'timeout'         => '10s',
            ]
        )
        ;

        return isset($response['status']) && $response['status'] !== 'red';
    }
}