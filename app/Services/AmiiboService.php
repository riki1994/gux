<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class AmiiboService
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $params
     * @return string
     * @throws GuzzleException
     */
    public function getAmiibo(array $params): string
    {
        $response = $this->client->get(
            'https://www.amiiboapi.com/api/amiibo',
            [
                'query' => $params,
            ]
        );

        return $response->getBody()->getContents();
    }
}
