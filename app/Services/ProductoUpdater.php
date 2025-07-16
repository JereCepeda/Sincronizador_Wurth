<?php

namespace App\Services;

use App\Models\Lista;
use Illuminate\Support\Facades\Log;
use App\Services\Scraper\WurthScraper;
use App\Services\Http\HttpClientInterface;
class ProductoUpdater
{
    protected WurthScraper $scraper;
    protected HttpClientInterface $http;
    public function __construct(WurthScraper $scraper)
    {
        $this->scraper = $scraper;
        $this->http = app(HttpClientInterface::class);
    }



    public function actualizarPreciosConUrl(string $codigo): void
    {

        $http = $this->http;
        $parser = new \App\Services\Scraper\DomParser();
        $search = new \App\Services\Scraper\WurthSearchService($http);
        $scraper = new \App\Services\Scraper\WurthScraper($http, $search, $parser);
        $producto = Lista::where('codigo_proveedor','=', $codigo )->first();

        $precio = $scraper->obtenerPrecioPorCodigoProveedor($producto->codigo_proveedor);
            if ($precio !== null) {
                $producto->precio_final = $precio;
                $producto->url = $search->buscarUrlProducto($producto->codigo_proveedor) ?? 'sin url';
                $producto->save();
                Log::info("Precio actualizado para el producto: {$producto->codigo_proveedor} - Nuevo precio: {$producto->precio_final}");
            } else {
                Log::warning("No se pudo obtener el precio para el producto: {$producto->codigo_proveedor}");
            }
    } 
}