<?php
namespace App\Services\Job;

use App\Services\ProductoUpdater;
use Illuminate\Support\Facades\Log;

class ActualizarProductosJobService
{   
    protected ProductoUpdater $productoUpdater;

    public function __construct(ProductoUpdater $productoUpdater)  {
        $this->productoUpdater = $productoUpdater;
    }

    public function ejecutar() {
        $productos = \App\Models\Lista::all();
        foreach ($productos as $producto) {
            Log::info('Actualizando producto con código: ' . $producto->codigo_proveedor);
            $this->productoUpdater->actualizarPreciosConUrl($producto->codigo_proveedor);    
        }
        Log::info('Actualización de precios para todos los productos completada');        
    }

}   