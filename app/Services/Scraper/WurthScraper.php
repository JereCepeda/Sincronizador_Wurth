<?php

namespace App\Services\Scraper;

use App\Services\GuzzleClientService;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Log;

class WurthScraper
{
    protected GuzzleClientService $http;

    public function __construct(GuzzleClientService $http)
    {
        $this->http = $http;
    }

    public function obtenerPrecio(string $url): ?float
    {
        try {
            $html = $this->http->get($url);
            $crawler = new Crawler($html);

            $elemento = $crawler->filter('.contenedor-precio .fweight-extrabold');
            if ($elemento->count() > 0) {  
                $texto = $elemento->text();
                return $this->limpiarPrecio($texto);
            }

        } catch (\Exception $e) {
            Log::error("Error al scrapear URL $url: " . $e->getMessage());
        }

        return null;
    }

    public function buscarYExtraerDesdeListado(string $urlBusqueda, string $codigo): array
    {
        try {
            $html = $this->http->get($urlBusqueda);
            $crawler = new Crawler($html);

            $productos = $crawler->filter('.producto');

            foreach ($productos as $domElement) {
                $elemento = new Crawler($domElement);

                $codigoExtraido = $elemento->filter('.codigo')->text('');
                if (trim(str_replace("Cód: ", "", $codigoExtraido)) === trim($codigo)) {
                    $url = $elemento->filter('.titulo')->attr('href');
                    $precio = $this->obtenerPrecio($url);
                    return [
                        'precioFinal' => $precio,
                        'urlFinal' => $url,
                    ];
                }
            }

        } catch (\Exception $e) {
            Log::error("Error buscando producto $codigo: " . $e->getMessage());
        }

        return [
            'precioFinal' => 0.0,
            'urlFinal' => 'sin url',
        ];
    }

    protected function limpiarPrecio(string $texto): float
    {
        $partes = explode(' ', $texto);
        return isset($partes[1]) ? (float)str_replace(',', '.', $partes[1]) : 0.0;
    }
}