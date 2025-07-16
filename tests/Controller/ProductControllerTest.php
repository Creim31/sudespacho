<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    // public function testListadoProductos(): void
    // {
    //     $client = static::createClient();
    //     $client->followRedirects(); // Sigue las redirecciones automáticamente
        
    //     $client->request(
    //         'GET', 
    //         '/api/productos',
    //         [],
    //         [],
    //         ['HTTP_ACCEPT' => 'application/json']
    //     );
        
    //     // Muestra información de depuración
    //     echo "Status Code: ".$client->getResponse()->getStatusCode()."\n";
    //     echo "Response: ".$client->getResponse()->getContent()."\n";
        
    //     $this->assertEquals(200, $client->getResponse()->getStatusCode());
    // }

 public function testCrearProductoExitoso(): void
{
    $client = static::createClient();
    
    // 1. Definimos los datos de prueba en variables
    $nombre = 'Producto2';
    $descripcion = 'Descripción de prueba2';
    $precioSinIva = 90;
    $tipoIva = 4;
    
    $data = [
        'nombre' => $nombre,
        'descripcion' => $descripcion,
        'precio_sin_iva' => $precioSinIva,
        'tipo_iva' => $tipoIva
    ];

    // 2. Calculamos el precio con IVA dinámicamente
    $precioConIvaEsperado = $precioSinIva * (1 + ($tipoIva / 100));

    $client->request(
        'POST',
        '/api/productos',
        [],
        [],
        [
            'HTTP_AUTHORIZATION' => 'Bearer admintoken',
            'CONTENT_TYPE' => 'application/json',
        ],
        json_encode($data)
    );

    // 3. Verificaciones
    $this->assertEquals(201, $client->getResponse()->getStatusCode());
    
    $response = json_decode($client->getResponse()->getContent(), true);
    $this->assertArrayHasKey('id', $response);
    $this->assertEquals($nombre, $response['nombre']); // Usamos la variable
    $this->assertEquals($precioConIvaEsperado, $response['precio_con_iva']); // Cálculo dinámico
}

}