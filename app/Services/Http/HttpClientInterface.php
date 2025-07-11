<?php

namespace App\Services\Http;

interface HttpClientInterface
{
    public function get(string $url);

    public function post(string $url, array $data): string;
}