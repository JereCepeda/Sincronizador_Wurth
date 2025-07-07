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
    public function getClient(): Client
    {
        return $this->client;
    }   

    public function get(string $url): string
    {
        $response = $this->client->get('https://www.wurth.com.ar/mi-cuenta.html', ['cookies' => true]);
        return $response->getBody()->getContents();
    }

    public function post(string $url, array $data): string
    {
        $response = $this->client->post('https://www.wurth.com.ar/login.html', [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0',
                'X-Requested-With' => 'XMLHttpRequest',
                'Referer' => 'https://www.wurth.com.ar/login.html',
            ],
            'form_params' => [
                'action' => 'authenticate',
                'home'   => '',
                'email'  => 'jcepeda@solucioneshm.com.ar',
                'clave'  => '22*Amato!',
            ],
            'cookies' => true,
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
