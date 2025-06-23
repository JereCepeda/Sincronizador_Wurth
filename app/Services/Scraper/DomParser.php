<?php
namespace App\Services\Scraper;

use Symfony\Component\DomCrawler\Crawler;

class DomParser
{
    public function getCrawler(string $html): Crawler
    {
        return new Crawler($html);
    }

    public function extraerPrecio(Crawler $crawler): ?float
    {
        $precio = null;

        $cantidad = $crawler->filter('.precios_por_cantidad_item_col .col-xs-5');
        $unitario = $crawler->filter('.contenedor-precio .fweight-extrabold');

        if ($cantidad->count()) {
            $precio = $this->limpiarPrecio($cantidad->text());
        } elseif ($unitario->count()) {
            $precio = $this->limpiarPrecio($unitario->text());
        }

        return $precio;
    }

    private function limpiarPrecio(string $texto): float
    {
        $partes = explode(' ', trim($texto));
        return isset($partes[1]) ? (float) str_replace(',', '.', $partes[1]) : 0.0;
    }
}