<?php

namespace App\Services;

use Elasticsearch\ClientBuilder;

class ElasticsearchLogger
{
    protected $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([env('ELASTICSEARCH_HOST', 'elasticsearch:9200')])
            ->build();
    }

    public function log(string $index, array $data)
    {
        return $this->client->index([
            'index' => $index,
            'body' => $data,
        ]);
    }
}
