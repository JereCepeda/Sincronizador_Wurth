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

    public function actualizarPreciosConUrl(): void
    {

        $http = new GuzzleClientService();
        $parser = new \App\Services\Scraper\DomParser();
        $search = new \App\Services\Scraper\WurthSearchService($http);
        $scraper = new \App\Services\Scraper\WurthScraper($http, $search, $parser);
        
        $productos = Lista::where('id', '=', 2)->get();
        // $producto = Lista::first();
        foreach ($productos as $producto) {
            $precio = $scraper->obtenerPrecioPorCodigoProveedor($producto->codigo_proveedor);
            if ($precio !== null) {
                $producto->precio_final = $precio;
                $producto->url = $search->buscarUrlProducto($producto->codigo_proveedor) ?? 'sin url';
                Log::info('Actualizando producto: ' . $producto->codigo_proveedor . ' con precio: ' . $producto->precio_final.' y URL: ' . $producto->url);
                $producto->save();
                info("Log de ProductoUpdater ".json_encode($producto));
            } else {
                Log::warning("No se pudo obtener el precio para el producto: {$producto->codigo_proveedor}");
            }
        } 
    }
        //     if ($producto->url) {
        //         Log::info('Actualizando: '.$producto->url);
        //         $precio = $this->scraper->obtenerPrecio($producto->url);
        //         if ($precio !== null) {
        //             $producto->precio_final = $precio;
        //             $producto->save();
        //         }
        //     }
     

    public function actualizarPreciosSinUrl(): void
    {
        $productos = Lista::where('url', '=', 'sin url')->orWhereNull('url')->get();

        // foreach ($productos as $producto) {
        //     $codigoFormateado = str_replace(' ', '+', trim($producto->codigo_proveedor));
        //     $busquedaUrl = "https://www.wurth.com.ar/es/busqueda/?term={$codigoFormateado}";

        //     $resultado = $this->scraper->buscarYExtraerDesdeListado($busquedaUrl, $producto->codigo_proveedor);

        //     $producto->precio_final = $resultado['precioFinal'] ?? 0.0;
        //     $producto->url = $resultado['urlFinal'] ?? 'sin url';
        //     $producto->save();
        // }
    }
}