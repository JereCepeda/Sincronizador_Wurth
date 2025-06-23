<?php

namespace App\Services;

use App\Models\Lista;
use App\Services\Scraper\WurthScraper;
use Illuminate\Support\Facades\Log;

class ProductoUpdater
{
    protected WurthScraper $scraper;

    public function __construct(WurthScraper $scraper)
    {
        $this->scraper = $scraper;
    }

    public function actualizarPreciosConUrl(): void
    {
        $productos = Lista::where('url', '!=', 'sin url')->get();

        foreach ($productos as $producto) {
            if ($producto->url) {
                Log::info('Actualizando: '.$producto->url);
                $precio = $this->scraper->obtenerPrecio($producto->url);
                if ($precio !== null) {
                    $producto->precio_final = $precio;
                    $producto->save();
                }
            }
        }
    }

    public function actualizarPreciosSinUrl(): void
    {
        $productos = Lista::where('url', '=', 'sin url')->orWhereNull('url')->get();

        foreach ($productos as $producto) {
            $codigoFormateado = str_replace(' ', '+', trim($producto->codigo_proveedor));
            $busquedaUrl = "https://www.wurth.com.ar/es/busqueda/?term={$codigoFormateado}";

            $resultado = $this->scraper->buscarYExtraerDesdeListado($busquedaUrl, $producto->codigo_proveedor);

            $producto->precio_final = $resultado['precioFinal'] ?? 0.0;
            $producto->url = $resultado['urlFinal'] ?? 'sin url';
            $producto->save();
        }
    }
}