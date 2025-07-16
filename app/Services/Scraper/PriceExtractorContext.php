<?php

namespace App\Services\Scraper;
use Symfony\Component\DomCrawler\Crawler;


class PriceExtractorContext
{
    protected array $strategies;

    public function __construct(array $strategies)
    {
        $this->strategies = $strategies;
    }

     public function obtenerPrecio(string $html,string $url): ?string
    {
        foreach ($this->strategies as $strategy) {
            $precio = $strategy->extraerPrecio($html, $url);
            if ($precio !== null) {
                return $precio;
            }
        }
        return null;
    }
}