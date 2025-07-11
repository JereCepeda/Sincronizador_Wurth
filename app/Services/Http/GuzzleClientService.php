<?php 

namespace App\Services\Http;

use GuzzleHttp\Client;
use App\Services\Http\HttpClientInterface;
use GuzzleHttp\Cookie\CookieJar;

class GuzzleClientService implements HttpClientInterface
{
    protected Client $client;

    protected CookieJar $cookieJar;

    public function __construct()
    {
        $this->cookieJar = new CookieJar();
        $this->client = new Client(['cookies' => $this->cookieJar]);
    }
    public function getClient(): Client
    {
        return $this->client;
    }   

    public function get(string $url)
    {
        $response = $this->client->get($url, ['cookies' => $this->cookieJar]);
        return $response->getBody()->getContents();
    }

    public function post(string $url, array $data): string
    {
        $response = $this->client->post($url, [
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
            'cookies' => $this->cookieJar]);
            
        return $response->getBody()->getContents();
    }
    
    protected function limpiarPrecio(string $texto): float
    {
        $texto = preg_replace('/[^\d,]/', '', $texto);
        $texto = str_replace(',', '.', $texto);
        return (float) $texto;
    }
}
