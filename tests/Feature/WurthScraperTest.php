<?php

namespace Tests\Feature\Feature;

use App\Services\Http\GuzzleClientService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WurthScraperTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $http = new GuzzleClientService();
        $parser = new \App\Services\Scraper\DomParser();
        $search = new \App\Services\Scraper\WurthSearchService($http);
        $scraper = new \App\Services\Scraper\WurthScraper($http, $search, $parser);

        $codigo = '95861 014 301'; 
        $precio = $scraper->obtenerPrecioPorCodigoProveedor($codigo);

        $this->assertNotNull($precio, "El precio no debería ser nulo para el código: $codigo");
        $this->assertIsFloat($precio, "El precio debería ser un número flotante para el código: $codigo");
        $this->assertGreaterThan(0, $precio, "El precio debería ser mayor que cero para el código: $codigo");
        echo "Precio obtenido para el código $codigo: $precio\n";
    }
}
