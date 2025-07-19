<?php

namespace App\Jobs;

use App\Services\Job\ActualizarProductosJobService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ActualizarProductoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $signature = 'productos:actualizar-precios';

    /**
     * Execute the job.
     */
    public function handle(ActualizarProductosJobService $service): void
    {
        $service->ejecutar();
        info('Todos los productos se actualizaron correctamente');
    }
}
