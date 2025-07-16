<?php

namespace App\Services\Scraper;


interface PriceSelectorStrategyInterface
{
    public function extraerPrecio(string $html,string $url): ?float;
}