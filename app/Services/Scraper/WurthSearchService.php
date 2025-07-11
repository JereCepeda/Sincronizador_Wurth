<?php

namespace App\Services\Scraper;

use Symfony\Component\DomCrawler\Crawler;
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
        $urlBusqueda = "https://www.wurth.com.ar/busqueda/?term=" . urlencode($codigo);
        $html = $this->http->get($urlBusqueda);
        $crawler = new Crawler($html);
        Log::info("URL de búsqueda: $urlBusqueda");
        $link = $crawler->filter('.lst_precio')->first();
        if ($link->count() === 0) return null;
        return $urlBusqueda;
    }
}