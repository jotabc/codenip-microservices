<?php

namespace App\Http\Client;

use App\Exception\HttpClientException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;

class HttpClient implements HttpClientInterface
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function get(string $url, array $options = []): ResponseInterface
    {
        try {
            return $this->client->get($url, $options);
        } catch (ClientException $e) {
            throw new HttpClientException($e->getResponse()->getStatusCode(), $e->getMessage());
        }
    }
}
