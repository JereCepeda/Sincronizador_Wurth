<?php   
namespace App\Services\Scraper;

interface ScraperInterface
{
    public function obtenerPrecioPorCodigoProveedor(string $codigo): ?float;
}