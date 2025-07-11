<?php

namespace App\Services\Scraper;


use App\Services\Scraper\DomParser;
use Illuminate\Support\Facades\Log;
use App\Services\Http\GuzzleClientService;
use App\Services\Scraper\WurthSearchService;

class WurthScraper implements ScraperInterface
{
    protected GuzzleClientService $http;
    protected WurthSearchService $search;
    protected DomParser $parser;

    public function __construct(GuzzleClientService $http, WurthSearchService $search, DomParser $parser)
    {
        $this->http = $http;
        $this->search = $search;
        $this->parser = $parser;
    }

    
    public function obtenerPrecioPorCodigoProveedor(string $codigo): ?float
    {
        try {
            $this->http->post('https://www.wurth.com.ar/login.html', [
                'action' => 'authenticate',
                'home'   => '',
                'email'  => 'jcepeda@solucioneshm.com.ar',
                'clave'  => '22*Amato!',
            ]);

            $url = $this->search->buscarUrlProducto($codigo);
            if (!$url) {
                Log::warning("Producto no encontrado: $codigo");
                return null;
            }

            $html = $this->http->get($url);
            return $this->parser->extraerPrecio($html);

        } catch (\Exception $e) {
            Log::error("Scraping fallido: {$e->getMessage()}");
            return null;
        }
    }

    // public function buscarYExtraerDesdeListado(string $urlBusqueda, string $codigo): array
    // {
    //     try {
    //         $html = $this->http->get($urlBusqueda);
    //         $crawler = new Crawler($html);

    //         $productos = $crawler->filter('.producto');

    //         foreach ($productos as $domElement) {
    //             $elemento = new Crawler($domElement);

    //             $codigoExtraido = $elemento->filter('.codigo')->text('');
    //             if (trim(str_replace("Cód: ", "", $codigoExtraido)) === trim($codigo)) {
    //                 $url = $elemento->filter('.titulo')->attr('href');
    //                 $precio = $this->obtenerPrecio($url);
    //                 return [
    //                     'precioFinal' => $precio,
    //                     'urlFinal' => $url,
    //                 ];
    //             }
    //         }

    //     } catch (\Exception $e) {
    //         Log::error("Error buscando producto $codigo: " . $e->getMessage());
    //     }

    //     return [
    //         'precioFinal' => 0.0,
    //         'urlFinal' => 'sin url',
    //     ];
    // }

    protected function limpiarPrecio(string $texto): float
    {
        $partes = explode(' ', $texto);
        return isset($partes[1]) ? (float)str_replace(',', '.', $partes[1]) : 0.0;
    }
}