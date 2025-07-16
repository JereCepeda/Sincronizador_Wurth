<?php

namespace App\Services\Scraper;

use App\Services\Http\HttpClientInterface;
use Illuminate\Support\Facades\Log;

Class WurthSearchService 
{
    protected HttpClientInterface $http;

    public function __construct(HttpClientInterface $http)
    {
        $this->http = $http;
    }

    public function buscarUrlProducto(string $codigo): ?string
    {
        $urlBusqueda = "https://www.wurth.com.ar/?action=buscador_codigo_barras&term=" . urlencode($codigo);
        $this->http->login('ventas@solucioneshm.com', 'Soluciones.H.M.3316');
        $response = $this->http->get($urlBusqueda);

        Log::info("Respuesta WurthSearchService JSON: " . $response);

        $json = json_decode($response, true);

        if (!isset($json['success']) || !$json['success'] || empty($json['data']['url'])) {return null;}
        
        return $json['data']['url'];
    }
}