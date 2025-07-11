<?php

namespace Tests\Feature;

use Tests\TestCase;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Support\Facades\Log;
use App\Services\Http\GuzzleClientService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GuzzleClientServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_login_and_get_protected_page()
    {
        $service = new GuzzleClientService();
       
        $loginUrl = 'https://www.wurth.com.ar/login.html';
        $protectedUrl = 'https://www.wurth.com.ar'; // Página privada poslogin

        $jar = new CookieJar(); // almacena cookies como PHPSESSID

        // Paso 1: Realizar login
        $loginResponse = $service->getClient()->post($loginUrl, [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0',
                'X-Requested-With' => 'XMLHttpRequest',
                'Referer' => 'https://www.wurth.com.ar/login.html',
            ],
            'form_params' => [
                'action' => 'authenticate',
                'home'   => '',
                'email'  => 'jcepeda@solucioneshm.com.ar',
                'clave'  => '22*Amato!',
            ],
            'cookies' => $jar,
        ]);

        $loginBody = $loginResponse->getBody()->getContents();

        // Validar si la respuesta del login contiene alguna palabra clave que indique éxito
        $this->assertStringNotContainsString('Usuario o contraseña incorrectos', $loginBody);

        // Paso 2: Acceder a página privada
        $protectedResponse = $service->getClient()->get($protectedUrl, ['cookies' => $jar]);

        $protectedHtml = $protectedResponse->getBody()->getContents();
        Log::info("HTML de la página protegida: $protectedHtml");
        // Validar que estamos logueados (buscando algo que solo aparece logueado)
        $this->assertStringContainsString('Mi cuenta', $protectedHtml);
    }
}