<?php

namespace App\Services\Scraper;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Log;

class ImporteSelector implements PriceSelectorStrategyInterface
{
    public function extraerPrecio(string $html,string $url): ?float
    {
        $crawler = new Crawler($html);
        $elemento = $crawler->filter('.importe');        
        if ($elemento->count() === 0) {
            return null;
        } elseif ($elemento->count() > 1) {
            Log::warning("Se encontraron múltiples precios, se usará el primero.");
        }

        $texto = $elemento->text();
        return $this->limpiarPrecio($texto);
    }

    private function limpiarPrecio(string $texto): string
    {
        $texto = preg_replace('/[^\d,]/', '', $texto);
        return str_replace(',', '.', $texto);
    }
}