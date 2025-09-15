<?php

namespace App\Http\Controllers;

use App\Services\Job\ActualizarProductosJobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

class PreciosController extends Controller
{   
    public function updatePrecios(Request $request)
        {
            $codigo = $request->input('codigo');
            $updater = app(\App\Services\ProductoUpdater::class);
            if ($codigo) {
                $updater->actualizarPreciosConUrl($codigo);
            } else {
                Log::warning("No se proporcionó un código de proveedor para actualizar precios.");
            }
        return response()->json(['success' => true, 'mensaje' => 'Actualización correcta']);
    }

    public function updateAllPrecios()
        {
            Log::info('Iniciando actualización de precios para todos los productos');
            app(ActualizarProductosJobService::class)->ejecutar();
            
            return response()->json([
                'success' => true, 
                'mensaje' => 'Actualización de precios completada'
            ]);
        }    
    public function updateAllJob()
    {

        Log::info('Iniciando actualización de precios en segundo plano');
        $productos = \App\Models\Lista::all();
        foreach ($productos as $producto) {
            \App\Jobs\ActualizarProductoJob::dispatch($producto->codigo_proveedor);
        }

        return response()->json([
            'success' => true, 
            'mensaje' => 'Actualización de precios iniciada en segundo plano'
        ]);
    }
}