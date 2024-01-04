<?php

namespace App\Http\Client;

use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface
{
    public function get(string $url, array $options = []): ResponseInterface;

}
