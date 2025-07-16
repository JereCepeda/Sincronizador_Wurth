<?php

namespace App\Services\Scraper;


use App\Services\Scraper\DomParser;
use Illuminate\Support\Facades\Log;
use App\Services\Http\HttpClientInterface;
use App\Services\Scraper\WurthSearchService;

class WurthScraper implements ScraperInterface
{
    protected HttpClientInterface $http;
    protected WurthSearchService $search;
    protected DomParser $parser;

    public function __construct(HttpClientInterface $http, WurthSearchService $search, DomParser $parser)
    {
        $this->http = $http;
        $this->search = $search;
        $this->parser = $parser;
    }

    
    public function obtenerPrecioPorCodigoProveedor(string $codigo): ?float
    {
        try {
            $this->http->login('ventas@solucioneshm.com','Soluciones.H.M.3316');

            $url = $this->search->buscarUrlProducto($codigo);
            if (!$url) {
                Log::warning("Producto no encontrado: $codigo");
                return null;
            }

            $html = $this->http->get($url);
            return $this->parser->extraerPrecio($html, $codigo);

        } catch (\Exception $e) {
            Log::error("Scraping fallido: {$e->getMessage()}");
            return null;
        }
    }

     protected function limpiarPrecio(string $texto): float
    {
        $partes = explode(' ', $texto);
        return isset($partes[1]) ? (float)str_replace(',', '.', $partes[1]) : 0.0;
    }

    public function obtenerPrecioDesdeJsonLd(array $jsonLd, string $targetUrl): ?float
    {
        if (!isset($jsonLd['hasVariant']) || !is_array($jsonLd['hasVariant'])) {return null;}

        foreach ($jsonLd['hasVariant'] as $variant) {
            if (isset($variant['offers']['url'], $variant['offers']['price'])) {
                $variantUrl = html_entity_decode($variant['offers']['url']);
                if (trim($variantUrl) === trim($targetUrl)) {
                    return (float) $variant['offers']['price'];
                }
            }
        }
        return null;
    }
}