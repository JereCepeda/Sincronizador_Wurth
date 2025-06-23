<?php 

namespace App\Services;

use GuzzleHttp\Client;

class GuzzleClientService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function get(string $url): string
    {
        $response = $this->client->get($url);
        return $response->getBody()->getContents();
    }

    public function post(string $url, array $data): string
    {
        $response = $this->client->post($url, [
            'form_params' => $data
        ]);
        return $response->getBody()->getContents();
    }
    
    protected function limpiarPrecio(string $texto): float
    {
        $texto = preg_replace('/[^\d,]/', '', $texto);
        $texto = str_replace(',', '.', $texto);
        return (float) $texto;
    }
}
