<?php
namespace App\Services\Scraper;

use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class DomParser
{
    public function getCrawler(string $html): Crawler
    {
        return new Crawler($html);
    }

     public function extraerPrecio(string $html): ?float
    {
        $crawler = new Crawler($html);
        $elemento = $crawler->filter('.f_producto_precios');
        info("Log DomParser Links encontrados: " . $elemento->count()); 
        if ($elemento->count() === 0) {
            return null;
        }else if ($elemento->count() > 1) {
            Log::warning("Se encontraron múltiples precios, se usará el primero.");
        }

        $texto = $elemento->text();
        return $this->limpiarPrecio($texto);
    }

    private function limpiarPrecio(string $texto): float
    {
        $texto = preg_replace('/[^\d,]/', '', $texto);
        $texto = str_replace(',', '.', $texto);
        return (float) $texto;
    }
}