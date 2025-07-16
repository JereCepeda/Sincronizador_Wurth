<?php

namespace App\Http\Controllers;

use App\Services\Job\ActualizarProductosJobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PreciosController extends Controller
{   
    public function updatePrecios(Request $request)
        {
            log::info('Iniciando actualización de precios con código: ' . json_encode($request->all()));
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
}
     