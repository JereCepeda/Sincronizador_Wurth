<?php

namespace App\Jobs;

use App\Services\ProductoUpdater;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ActualizarProductoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected string $codigo;

    /**
     * Create a new job instance.
     */
    public function __construct(string $codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * Execute the job.
     */
    public function handle(ProductoUpdater $productoUpdater): void
    {
        $productoUpdater->actualizarPreciosConUrl($this->codigo);
        info('Producto actualizado correctamente: ' . $this->codigo);
    }
}
