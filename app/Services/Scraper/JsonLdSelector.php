<?php

namespace App\Services\Scraper;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Log;

class JsonLdSelector implements PriceSelectorStrategyInterface
{
     public function extraerPrecio(string $html, string $codigo): ?float
    {
        info("Extraer precio desde JSON-LD");
        info("URL objetivo: " . $codigo);
        $jsonLd = $this->extraerJsonLd($html,$codigo);
        if (!$jsonLd) {
            return null;
        }
        $precio = $this->buscarPrecioEnVariantes($jsonLd, $codigo);
        if ($precio !== null) {
            info("Precio encontrado: " . $precio);
            return $precio;
        } else {
            Log::warning("No se encontró el precio para el código: {$codigo}");
            return null;
        }
        ;
    }

    public function extraerJsonLd(string $html,$codigo)
    {
        info('traza aa extraerJsonLd');
        $crawler = new Crawler($html);
        $scriptNodes = $crawler->filter('script[type="application/ld+json"]');
        foreach ($scriptNodes as $node) {
            $jsonContent = $node->textContent;

            $jsonContent = trim($jsonContent);
            $jsonContent = preg_replace('/[\x00-\x1F\x7F]/u', '', $jsonContent);
            $jsonContent = preg_replace('/\\\\u000[0-9a-f]/i', '', $jsonContent);
            $jsonContent = str_replace(["\n", "\r", "\t"], '', $jsonContent); 
            $data = json_decode($jsonContent, true);
            return $data;
                        
        }
    }

    public function buscarPrecioEnVariantes(array $jsonLd, string $codigo): ?float
    {
           $codigo = trim(html_entity_decode($codigo));

            if ( isset($jsonLd['@type']) && $jsonLd['@type'] === 'Product' && isset($jsonLd['sku'], $jsonLd['offers']['price'])){
                $sku = trim(html_entity_decode($jsonLd['sku']));
                if ($sku === $codigo) 
                    return (float) $jsonLd['offers']['price'];
                }

            if (isset($jsonLd['@type']) && $jsonLd['@type'] === 'ProductGroup' && isset($jsonLd['hasVariant']) && is_array($jsonLd['hasVariant']))
             {
                foreach ($jsonLd['hasVariant'] as $variant) {
                    $sku = trim(html_entity_decode($variant['sku'] ?? ''));
                    if ($sku === $codigo && isset($variant['offers']['price'])) 
                        return (float) $variant['offers']['price'];
                    }
                }

        return null;
    }
}