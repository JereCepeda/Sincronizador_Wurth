<?php
namespace App\Services\Scraper;

use App\Services\Scraper\ImporteSelector;
use App\Services\Scraper\PrecioSelector;
use App\Services\Scraper\JsonLdSelector;
use App\Services\Scraper\PriceExtractorContext;
class DomParser
{
   
    protected PriceExtractorContext $context;

    public function __construct()
    {
        $this->context = new PriceExtractorContext([
            new JsonLdSelector(),
        ]);
    }

    public function extraerPrecio(string $html,string $url): ?float
    {
        $precioTexto = $this->context->obtenerPrecio($html,$url);
        if (!$precioTexto) {
            return null;
        }
        return $precioTexto;
    }
}