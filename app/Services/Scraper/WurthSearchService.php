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

        $response = $this->http->get($urlBusqueda);

        Log::info("Respuesta WurthSearchService JSON: " . $response);

        $json = json_decode($response, true);

        if (!is_array($json) || empty($json['success']) || empty($json['data']['url'])) {
            Log::warning("No se pudo extraer la URL del JSON para el código: $codigo");
            return null;
        }

        // Retornar la URL limpia
        $url = html_entity_decode($json['data']['url']);
        info("URL encontrada: $url");
        return $url;
    }
}