<?php

namespace App\Services;

use App\Models\Lista;
use Illuminate\Support\Facades\Log;
use App\Services\Scraper\WurthScraper;
use App\Services\Http\GuzzleClientService;

class ProductoUpdater
{
    protected WurthScraper $scraper;

    public function __construct(WurthScraper $scraper)
    {
        $this->scraper = $scraper;
    }

    public function actualizarPreciosConUrl(string $codigo): void
    {

        $http = new GuzzleClientService();
        $parser = new \App\Services\Scraper\DomParser();
        $search = new \App\Services\Scraper\WurthSearchService($http);
        $scraper = new \App\Services\Scraper\WurthScraper($http, $search, $parser);
        $producto = Lista::where('codigo_proveedor','=', $codigo )->first();

        $precio = $scraper->obtenerPrecioPorCodigoProveedor($producto->codigo_proveedor);
            if ($precio !== null) {
                $producto->precio_final = $precio;
                $producto->url = $search->buscarUrlProducto($producto->codigo_proveedor) ?? 'sin url';
                $producto->save();
            } else {
                Log::warning("No se pudo obtener el precio para el producto: {$producto->codigo_proveedor}");
            }
    } 
   
    // public function actualizarPreciosSinUrl(): void
    // {
        // $productos = Lista::where('url', '=', 'sin url')->orWhereNull('url')->get();

        // foreach ($productos as $producto) {
        //     $codigoFormateado = str_replace(' ', '+', trim($producto->codigo_proveedor));
        //     $busquedaUrl = "https://www.wurth.com.ar/es/busqueda/?term={$codigoFormateado}";

        //     $resultado = $this->scraper->buscarYExtraerDesdeListado($busquedaUrl, $producto->codigo_proveedor);

        //     $producto->precio_final = $resultado['precioFinal'] ?? 0.0;
        //     $producto->url = $resultado['urlFinal'] ?? 'sin url';
    //         $producto->save();
    //     }
}